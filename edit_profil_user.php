<?php
    require_once 'inc/header.php'; 
    require_once 'entity/UtilisateursManager.php';
    require_once 'entity/Utilisateur.php';

    //si utilisateur  et entreprise n'est pas connecte il est rediriger a connexion.php 
    // Seul un utilisateur connecté peut avoir accès a cette page
    if((!utilisateurEstConnecte() && !entrepriseEstConnecte() || entrepriseEstConnecte())){
        header('location:connexion.php');
    }

    //instanciation d'une classe utilisateur manager
    // pour pouvoir mettre a jour les donnees dans la bdd
    $utilisateurManager = new UtilisateursManager($pdo);
   

    if($_POST){
            // instanciation d'une nouvelle class utilisateur
            $utilisateur = new Utilisateur([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'mdp' => $_POST['mdp'],
                'tel' => $_POST['tel'],
                'civilite' => $_POST['civilite'],
                'ville' => $_POST['ville']
            ]);

            // S'il n'y a pas d'erreur dans le formulaire
            // on fait une insertion des donnees du formulaire dans la base de donne
            // Sinon on affiche les erreurs
            if($utilisateur->isUserValide()){
                $utilisateurManager->update_utilisateur($_SESSION['user']['id_utilisateur'],$_POST); // MAJ les donnees dans bdd

                // On recupere les dernières modifications apportées à l'utilisateur dans la bdd
                $currUtilisateur = $utilisateurManager->afficherUtilisateur($_POST['email'], $_POST['nom']);

                // On affecte les dernières infos de l'utilisateur dans une session user
                $_SESSION['user']['id_utilisateur'] = $currUtilisateur['id_utilisateur'];
                $_SESSION['user']['nom'] = $currUtilisateur['nom'];
                $_SESSION['user']['prenom'] = $currUtilisateur['prenom'];
                $_SESSION['user']['email'] = $currUtilisateur['email'];
                $_SESSION['user']['tel'] = $currUtilisateur['tel'];
                $_SESSION['user']['civilite'] = $currUtilisateur['civilite'];
                $_SESSION['user']['ville'] = $currUtilisateur['ville'];


                $content .= alertMessage("success","Les modifications ont bien été enregistrées");
            } else {
                // ici on récupère les erreurs si il y en a
                $erreurs = $utilisateur->getErreurs();

                // ici on affiche les erreurs avec une boucle foreach
                foreach($erreurs as $erreur){
                    $content .= alertMessage('danger', $erreur);
                }
            }
    }
?>

<h1 class="text-center my-3" >Editer votre profil <?= $_SESSION['user']['nom'] ." ". $_SESSION['user']['prenom'] ?></h1>

<a href="profil.php" class="btn btn-dark ms-4">Retour sur le profil</a>

<section class="col-md-6 mx-auto m-1 py-3">
    
    
    <!-- Formulaire modification utilisateur -->
    <form action="" method="post" id="form-user">
      
        <?= $content; ?>
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" value="<?= $_SESSION['user']['nom']?>" placeholder="Entrer votre nom..." />
        </div>

        <div class="mb-3">
            <label for="prenom">Prenom</label>
            <input class="form-control" type="text" name="prenom" id="prenom" value="<?= $_SESSION['user']['prenom']?>" placeholder="Entrer votre prenom..." />
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= $_SESSION['user']['email']?>" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe (entrez le même mdp que lors de l'inscription. PS: on a pas eu le temps de gérer le nouveau mdp 😅)</label>
            <input class="form-control" type="password" name="mdp" id="mdp"  placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mb-3">
            <label for="tel">Tel</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="<?= $_SESSION['user']['tel']?>" placeholder="Entrer votre numero de telephone..." />
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
            <input class="form-control" type="text" name="ville" id="ville" value="<?= $_SESSION['user']['ville']?>" placeholder="Entrer votre ville..." />
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Enregistrer modifications</button>
        </div>
    </form>

    
 
</section>

<?php require_once 'inc/footer.php'; ?>