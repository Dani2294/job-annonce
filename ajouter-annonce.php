<?php 

    require_once 'inc/header.php';
    require_once 'entity/Annonce.php';
    require_once 'entity/AnnoncesManager.php';

    if(!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()){
        header('location:connexion.php');
    }

    $annonceManager = new AnnoncesManager($pdo);
    if($_POST)
    {   
        //var_dump($annonceManager->recupEntrepriseAnnonces($_SESSION['entreprise']['id_entreprise']));
        // on verifie si le titre existe déjà
        //if($annonceManager->verifTitre($_POST['titre'])){
          //  $content .= $annonceManager->alertMessage('danger', 'Ce titre existe déjà');
        //} else{
            $annonce = new Annonce([
                'id_entreprise' => $_SESSION['entreprise']['id_entreprise'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'localisation' => $_POST['localisation'],
                'contrat' => $_POST['contrat'],
                'date_ajout' => $_POST['date_ajout'],
               ]);
            // var_dump($_POST);
            $annonceManager->inserer($annonce);
            $content .= $annonceManager->alertMessage('success', 'votre annonce a bien été ajoutée');
        //}
        
    }


?>


<h1 class="text-center my-4">Ajouter une annonce</h1>
<div>
<a href="espaceEntreprise.php">retour sur espace entreprise</a>
</div>
 
<!-- Formulaire ajout d'annonces -->
 <section class="col-md-6 mx-auto m-1 py-3">
 <form action="" method="post"  >
        <?= $content; ?>
        <div class="mb-3">
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre" value="" placeholder="Entrez le titre de l'annonce..." />
        </div>

        <div class="mb-3">
            <label for="contrat">Contrat</label>
            <select name="contrat" id="contrat" class="form-control">
                <option value="">Choisissez le type du contrat</option>
                <option value="cdi">CDI</option>
                <option value="cdd">CDD</option>
                <option value="alternance">ALTERNANCE</option>
                <option value="stage">STAGE</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_ajout">Date d'ajout</label>
            <input class="form-control" type="date" name="date_ajout" id="date_ajout"/>
        </div>

        <div class="mb-3">
            <label for="localisation">Localisation</label>
            <input class="form-control" type="text" name="localisation" id="localisation" value="" placeholder="Entrez la ville (Ex:Paris)..." />
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea class="form-control"  name="description" id="description"  placeholder="Entrez la description de l'annonce..." >
            </textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Ajouter annonce</button>
        </div>
    </form>
    </section>






<?php require_once 'inc/footer.php'; ?>

