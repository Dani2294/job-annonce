<?php 
    //a modifier
    require_once 'inc/header.php'; 

    require_once 'entity/Entreprise.php';
    require_once 'entity/EntreprisesManager.php';

    if(!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()){
        header('location:connexion.php');
    }

  
    $entrepriseManager = new EntreprisesManager($pdo);
   

    if($_POST){

       
            // Do stuff for the entreprise
            $entreprise = new Entreprise([
                'nom' => $_POST['nom'],
                'email' => $_POST['email'],
                'tel' => $_POST['tel'],
                'ville' => $_POST['ville'],
                'secteur_activite' => $_POST['secteur_activite'],
                'presentation' => $_POST['presentation'],

            ]);

            if($entreprise->isEntrepriseValide()){
               $entrepriseManager->update_entreprise($_SESSION['entreprise']['id_entreprise'],$_POST);
               $content .= $entrepriseManager->alertMessage("success","Les modifications ont bien été enregistrées");
            }
       
            
            
        
    }
?>

<h1 class="text-center my-3" >Editer profil</h1>

<section class="col-md-6 mx-auto m-1 py-3">
    
    
    <!-- Formulaire modification utilisateur -->
    <form action="" method="post" id="form-entreprise">
      
        <?= $content; ?>
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" value="<?= $_SESSION['entreprise']['nom']?>" placeholder="Entrer votre nom..." />
        </div>
       

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= $_SESSION['entreprise']['email']?>" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input class="form-control" type="password" name="mdp" id="mdp"  placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mb-3">
            <label for="tel">Tel</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="<?= $_SESSION['entreprise']['tel']?>" placeholder="Entrer votre numero de telephone..." />
        </div>


        <div class="mb-3">
            <label for="ville">Ville</label>
            <input class="form-control" type="text" name="ville" id="ville" value="<?= $_SESSION['entreprise']['ville']?>" placeholder="Entrer votre ville..." />
        </div>


        <div class="mb-3">
            <label for="secteur_activite">Secteur d'activité</label>
            <input class="form-control" type="text" name="secteur_activite" id="secteur_activite" value="<?= $_SESSION['entreprise']['secteur_activite']?>" placeholder="Entrer votre secteur d'activité" />
        </div>


        <div class="mb-3">
            <label for="presentation">Presentation</label>
            <textarea class="form-control"  name="presentation" id="presentation"  placeholder="Decrivez votre entreprise" >
            <?= $_SESSION['entreprise']['presentation']?>
            </textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Enregistrer modifications</button>
        </div>
    </form>

    
 
</section>

<?php require_once 'inc/footer.php'; ?>