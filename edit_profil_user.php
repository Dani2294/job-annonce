<?php
    require_once 'inc/header.php'; 
    require_once 'entity/UtilisateursManager.php';
    require_once 'entity/Utilisateur.php';

    //si utilisateur  et entreprise n'est pas connecte il est rediriger a connexion.php 
    if((!utilisateurEstConnecte() && !entrepriseEstConnecte() || entrepriseEstConnecte())){
        header('location:connexion.php');
    }

    //instanciation d'une classe utilisateur manager
    $utilisateurManager = new UtilisateursManager($pdo);
   

    if($_POST){

       
            // Do stuff for the user
            // instanciation d'un nouvelle utilisateur
            $utilisateur = new Utilisateur([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'mdp' => $_POST['mdp'],
                'tel' => $_POST['tel'],
                'civilite' => $_POST['civilite'],
                'ville' => $_POST['ville']
            ]);

             // s il n y a pas erreur dans le formulaire alors  
             // on met a jour les informations de utilisateur
            if($utilisateur->isUserValide()){
               $utilisateurManager->update_utilisateur($_SESSION['user']['id_utilisateur'],$_POST);
               $content .= alertMessage("success","Les modifications ont bien été enregistrées");
            }
       
            
            
        
    }
?>

<h1 class="text-center my-3" >Editer profil</h1>

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
            <label for="mdp">Mot de passe</label>
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