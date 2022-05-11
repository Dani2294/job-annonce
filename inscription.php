<?php
    require_once 'inc/header.php'; 
    require_once 'entity/UtilisateursManager.php';
    require_once 'entity/Utilisateur.php';
    require_once 'entity/Entreprise.php';
    require_once 'entity/EntreprisesManager.php';


    $utilisateurManager = new UtilisateursManager($pdo);
    $entrepriseManager = new EntreprisesManager($pdo);

    if($_POST){
        //var_dump($_FILES['logo']);
        if(isset($_GET['type']) && $_GET['type'] == 'user'){
            // Do stuff for the user
            $utilisateur = new Utilisateur([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'mdp' => $_POST['mdp'],
                'tel' => $_POST['tel'],
                'civilite' => $_POST['civilite'],
                'ville' => $_POST['ville']
            ]);

            if($utilisateur->isUserValide()){
                $utilisateurManager->inserer($utilisateur); //insert dans la bdd
                $content .= $utilisateurManager->alertMessage('success', 'Votre compte a bien été créé !');
            }
        } elseif(isset($_GET['type']) && $_GET['type'] == 'entreprise'){
            // Do stuff for the entreprise
            
            //$logo_bdd = "";
            if(!empty($_FILES['logo']['name'])){
                $entreprise = new Entreprise([
                    'nom' => $_POST['nom'],
                    'email' => $_POST['email'],
                    'mdp' => $_POST['mdp'],
                    'tel' => $_POST['tel'],
                    'ville' => $_POST['ville'],
                    'secteur_activite' => $_POST['activite'],
                    'presentation' => $_POST['presentation'],
                    'logo' => $_FILES['logo']
                ]);

                if($entreprise->isUserValide()){
                    $entrepriseManager->inserer($entreprise);
                    $content .= $entrepriseManager->alertMessage('success', 'Votre compte a bien été créé !');
                }
            }
            
        }
    }
?>

<h1 class="text-center my-3" >Inscription</h1>

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
            <label for="prenom">Prenom</label>
            <input class="form-control" type="text" name="prenom" id="prenom" value="" placeholder="Entrer votre prenom..." />
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mb-3">
            <label for="tel">Tel</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="" placeholder="Entrer votre numero de telephone..." />
        </div>

        <div class="mb-3">
            <label for="civilite">Civilite</label>
            <select class="form-control" name="civilite" id="civilite">
                <option value="m">Homme</option>
                <option value="f">Femme</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ville">Ville</label>
            <input class="form-control" type="text" name="ville" id="ville" value="" placeholder="Entrer votre ville..." />
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Inscription</button>
        </div>
    </form>
    <?php endif; ?>
    
    <?php if(isset($_GET['type']) && $_GET['type'] == 'entreprise'): ?>
    <!-- Formulaire inscription entreprise -->
    <form action="" method="post" enctype="multipart/form-data" id="form-entreprise">
        <h2 class="text-center fs-4">Entreprise</h2>
        <?= $content; ?>
        <div class="mb-3">
            <label for="nom">Nom de l'entreprise</label>
            <input class="form-control" type="text" name="nom" id="nom" value="" placeholder="Entrer le nom de l'entreprise..." />
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mb-3">
            <label for="tel">Tel</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="" placeholder="Entrer votre numero de telephone..." />
        </div>

        <div class="mb-3">
            <label for="ville">Localisation</label>
            <input class="form-control" type="text" name="ville" id="ville" value="" placeholder="Entrer votre ville d'activite..." />
        </div>

        <div class="mb-3">
            <label for="activite">Secteur d'activite</label>
            <input class="form-control" type="text" name="activite" id="activite" value="" placeholder="Entrer votre secteur d'activite..." />
        </div>

        <div class="mb-3">
            <label for="presentation">Presentation de l'entreprise</label>
            <textarea class="form-control" name="presentation" id="presentation" rows="3" placeholder="Rapide présentation de votre entreprise..."></textarea>
        </div>

        <div class="mb-3">
            <label for="logo">Ajouter votre logo</label>
        <input class="form-control" type="file" name="logo" id="logo" value="" placeholder="Votre logo..." />
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Inscription</button>
        </div>
    </form>
    <?php endif; ?>
</section>

<?php require_once 'inc/footer.php'; ?>