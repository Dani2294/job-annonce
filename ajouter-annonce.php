<?php 

    require_once 'inc/header.php';
    require_once 'entity/Annonce.php';
    require_once 'entity/AnnoncesManager.php';

    // Si l'entreprise n'est pas connectée, et que l'utilisateur est ou n'est pas connecté
    // on le redirige vers la page connexion
    // Seulement une entreprise qui est connecté qui peut avoir accès a cette page
    if(!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()){
        header('location:connexion.php');
    }

    // On instancie une class AnnonceManager
    // qui va nous permettre d'ajouter les annonces dans la bdd
    $annonceManager = new AnnoncesManager($pdo);


    if($_POST)
    {
        // On instancie une nouvelle class Annonce
        $annonce = new Annonce([
            'id_entreprise' => $_SESSION['entreprise']['id_entreprise'], // On récupère l'id de l'entreprise connectée grace a la session
            'titre' => $_POST['titre'],
            'nom_entreprise' => $_SESSION['entreprise']['nom'], // On récupère le nom de l'entreprise grace a la session
            'description' => $_POST['description'],
            'localisation' => $_POST['localisation'],
            'contrat' => $_POST['contrat'],
            'date_ajout' => $_POST['date_ajout'],
            'logo_entreprise' => $_SESSION['entreprise']['logo'] // On récupère le logo de l'entreprise connectée grace a la session
        ]);

        // S'il n'y a pas d'erreurs ajoute l'annonce à la base de données
        // Sinon on affiche les erreurs
        if($annonce->isAnnonceValid()){
            $annonceManager->inserer($annonce); // Ici on ajoute l'annonce à la base de données
            $content .= alertMessage('success', 'votre annonce a bien été ajoutée');
        } else {
            // ici on récupère les erreurs si il y en a
            $erreurs = $annonce->getErreurs();

            // ici on affiche les erreurs avec un boucle foreach
            foreach($erreurs as $erreur){
                $content .= alertMessage('danger', $erreur);
            }
        }
    }


?>


<h1 class="text-center my-4">Ajouter une annonce</h1>
<div>
<a href="espaceEntreprise.php" class="btn btn-dark ms-4">Retour sur espace entreprise</a>
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
            <input class="form-control" type="date" name="date_ajout" id="date_ajout" />
        </div>

        <div class="mb-3">
            <label for="localisation">Localisation</label>
            <input class="form-control" type="text" name="localisation" id="localisation" value="" placeholder="Entrez la ville (Ex:Paris)..." />
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea class="form-control"  name="description" id="description"  placeholder="Entrez la description de l'annonce..." ></textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-success">Ajouter annonce</button>
        </div>
    </form>
    </section>



<?php require_once 'inc/footer.php'; ?>

