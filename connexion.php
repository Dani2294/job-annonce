<?php
    require_once 'inc/header.php';
    require_once 'entity/UtilisateursManager.php';
    require_once 'entity/EntreprisesManager.php';

    if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
        unset($_SESSION['user']);
        unset($_SESSION['entreprise']);

        header('location:connexion.php');
    }

    if(utilisateurEstConnecte()){
        header('location:profil.php');
    } elseif(entrepriseEstConnecte()){
        header('location:administration.php');
    }

   

    $utilisateurManager = new UtilisateursManager($pdo);
    $entrepriseManager = new EntreprisesManager($pdo);

    if($_POST){
        if(isset($_GET['type']) && $_GET['type'] == 'user'){
            // Do stuff for the user
            //var_dump($_POST);
            $currUtilisateur = $utilisateurManager->afficherUtilisateur($_POST['email']);
            if(!empty($currUtilisateur) && password_verify($_POST['mdp'], $currUtilisateur['mdp'])){
                //var_dump($currUtilisateur);
                $_SESSION['user']['id_utilisateur'] = $currUtilisateur['id_utilisateur'];
                $_SESSION['user']['nom'] = $currUtilisateur['nom'];
                $_SESSION['user']['prenom'] = $currUtilisateur['prenom'];
                $_SESSION['user']['email'] = $currUtilisateur['email'];
                $_SESSION['user']['tel'] = $currUtilisateur['tel'];
                $_SESSION['user']['civilite'] = $currUtilisateur['civilite'];
                $_SESSION['user']['ville'] = $currUtilisateur['ville'];

                if(isset($_SESSION['entreprise'])){
                    unset($_SESSION['entreprise']);
                }

                header('location: profil.php');
                //var_dump($_SESSION['entreprise']);
            }
        } elseif(isset($_GET['type']) && $_GET['type'] == 'entreprise'){
            // Do stuff for the entreprise
            $currEntreprise = $entrepriseManager->afficherEntreprise($_POST['email']);
            if(!empty($currEntreprise) && password_verify($_POST['mdp'], $currEntreprise['mdp'])){
                $_SESSION['entreprise']['id'] = $currEntreprise['id_entreprise'];
                $_SESSION['entreprise']['nom'] = $currEntreprise['nom'];
                $_SESSION['entreprise']['email'] = $currEntreprise['email'];
                $_SESSION['entreprise']['tel'] = $currEntreprise['tel'];
                $_SESSION['entreprise']['ville'] = $currEntreprise['ville'];
                $_SESSION['entreprise']['secteur_activite'] = $currEntreprise['secteur_activite'];
                $_SESSION['entreprise']['presentation'] = $currEntreprise['presentation'];

                if(isset($_SESSION['user'])){
                    unset($_SESSION['user']);
                }

                header('location: administration.php');
                //var_dump($_SESSION['user']);
            }
        }
    }
?>

<h1 class="text-center my-3" >Connexion</h1>

<section class="col-md-6 mx-auto m-1 py-3">
    <div class="d-flex justify-content-center my-3">
        <a class="btn btn-dark m-2" id="btn-user" href="?type=user" >Je suis un utilisateur</a>
        <a class="btn btn-primary m-2" id="btn-entreprise" href="?type=entreprise" >Je suis une entreprise</a>
    </div>

    <?php if(isset($_GET['type']) && $_GET['type'] == 'user'): ?>
    <!-- Formulaire inscription utilisateur -->
    <form action="" method="post" id="form-user">
        <h2 class="text-center fs-4">Utilisateur</h2>
        <?= $content; ?>
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" value="" placeholder="Entrer votre nom..." />
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Connexion</button>
        </div>
    </form>
    <?php endif; ?>
    
    <?php if(isset($_GET['type']) && $_GET['type'] == 'entreprise'): ?>
    <!-- Formulaire inscription entreprise -->
    <form action="" method="post" enctype="multipart/form-data" id="form-entreprise">
        <h2 class="text-center fs-4">Entreprise</h2>
        <?= $content; ?>
        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Connexion</button>
        </div>
    </form>
    <?php endif; ?>
</section>

<?php require_once 'inc/footer.php'; ?>