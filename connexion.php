<?php
    require_once 'inc/header.php';
    require_once 'entity/UtilisateursManager.php';
    require_once 'entity/EntreprisesManager.php';

    // On deconnecte l'utilisateur ou l'entreprise connecte
    // si il y a une action de type deconnexion dans l'url
    // puis on le redirige vers la page connexion
    if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
        unset($_SESSION['user']);
        unset($_SESSION['entreprise']);

        // On redirige vers la page connexion
        header('location:connexion.php');
    }

    // Si l'utilisateur ou l'entreprise est déjà connecte 
    // on le/la redirige vers la page de son profil / son espace entreprise
    if(utilisateurEstConnecte()){
        header('location:profil.php');
    } elseif(entrepriseEstConnecte()){
        header('location:espaceEntreprise.php');
    }

    // On instancie deux class UtilisateursManager et EntreprisesManager
    $utilisateurManager = new UtilisateursManager($pdo);
    $entrepriseManager = new EntreprisesManager($pdo);

    if($_POST){
        if(isset($_GET['type']) && $_GET['type'] == 'user'){
            // Ici on gère la connexion d'un utilisateur

            // On recupere les informations de l'utilisateur qui correspond à 
            // l'email entrer dans le formulaire de conexion
            $currUtilisateur = $utilisateurManager->afficherUtilisateur($_POST['email'], $_POST['nom']);

            // On verifie qu'il y à bien un utilisateur avec ce nom et cette email
            if(!empty($currUtilisateur)){

                // On verifie que le mot de passe correspond
                if(password_verify($_POST['mdp'], $currUtilisateur['mdp'])){

                    // On affecte les infos de l'utilisateur dans une session user
                    $_SESSION['user']['id_utilisateur'] = $currUtilisateur['id_utilisateur'];
                    $_SESSION['user']['nom'] = $currUtilisateur['nom'];
                    $_SESSION['user']['prenom'] = $currUtilisateur['prenom'];
                    $_SESSION['user']['email'] = $currUtilisateur['email'];
                    $_SESSION['user']['tel'] = $currUtilisateur['tel'];
                    $_SESSION['user']['civilite'] = $currUtilisateur['civilite'];
                    $_SESSION['user']['ville'] = $currUtilisateur['ville'];
    
                    // Si une session entreprise existe, on la supprime
                    // car on ne peut pas être connecté comme entreprise et utilisateur à la fois
                    if(isset($_SESSION['entreprise'])){
                        unset($_SESSION['entreprise']);
                    }

                    // On redirige vers sa page profil
                    header('location:profil.php');

                } else {
                    $content .= alertMessage('danger', 'Votre mot de passe est incorrect');
                }
            } else {
                $content .= alertMessage('danger', 'Votre <b>nom</b> ou <b>email</b> est incorrect <br> ou cet utilisateur n\'existe pas encore');
            }
        } elseif(isset($_GET['type']) && $_GET['type'] == 'entreprise'){
            // Ici on gère la connexion d'une entreprise

              // On recupere les informations de l'entreprise qui correspond à 
            // l'email entrer dans le formulaire de conexion
            $currEntreprise = $entrepriseManager->afficherEntreprise($_POST['email']);

            // On verifie qu'il y a bien une entreprise avce cette email
            if(!empty($currEntreprise)){

                // On verifie que le mot de passe correspond
                if(password_verify($_POST['mdp'], $currEntreprise['mdp'])){
                    // On affecte les infos de l'entreprise dans une session entreprise
                    $_SESSION['entreprise']['id_entreprise'] = $currEntreprise['id_entreprise'];
                    $_SESSION['entreprise']['nom'] = $currEntreprise['nom'];
                    $_SESSION['entreprise']['email'] = $currEntreprise['email'];
                    $_SESSION['entreprise']['tel'] = $currEntreprise['tel'];
                    $_SESSION['entreprise']['ville'] = $currEntreprise['ville'];
                    $_SESSION['entreprise']['secteur_activite'] = $currEntreprise['secteur_activite'];
                    $_SESSION['entreprise']['presentation'] = $currEntreprise['presentation'];
                    $_SESSION['entreprise']['logo'] = $currEntreprise['logo'];

                    // Si une session entreprise existe, on la supprime
                    // car on ne peut pas être connecté comme entreprise et utilisateur à la fois
                    if(isset($_SESSION['user'])){
                        unset($_SESSION['user']);
                    }

                    // On redirige vers sa page espace entreprise
                    header('location: espaceEntreprise.php');
                } else {
                    $content .= alertMessage('danger', 'Votre mot de passe est incorrect');
                }
            } else {
                $content .= alertMessage('danger', 'Votre <b>email</b> est incorrect <br> ou cette entreprise n\'existe pas encore');
            }
        }
    }
?>

<h1 class="text-center my-3" >Connexion</h1>

<section class="col-md-6 mx-auto m-1 py-3">
    <!-- Ici les boutons qui permettent d'affiche le formulaire de connexion de l'uitilisateur ou de l'entreprise -->
    <div class="d-flex justify-content-center my-3">
        <a class="btn btn-dark m-2" id="btn-user" href="?type=user">Je suis un utilisateur</a>
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