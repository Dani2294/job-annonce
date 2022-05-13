<?php

    require_once "inc/header.php";
    require_once "entity/EntreprisesManager.php";
    require_once "entity/AnnoncesManager.php";

    //si entreprise et utilisateur n'est pas connecte il est rediriger vers connexion.php 
    // seulement une entrepise qui est connecté peut avoir accès a cette page
    if (!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()) {
        header('location:connexion.php');
    }

    // On instancie une class AnnoncesManager
    // qui vas nous servir à gérer les annonces de l'entreprise connecte
    $annonceManager = new AnnoncesManager($pdo);
    
    // affectation de url du logo dans la variable $logo
    // afin de l'afficher sur la page
    $logo = $_SESSION['entreprise']['logo'];
    
    if (isset($_GET['action'])) {
        //ici on gère la suppression du compte de l'entreprise
        if($_GET['action'] == 'supprimer-compte'){

            // On supprime toutes les annonces de cette entreprise
            $annonceManager->delete_entreprise_annonces($_SESSION['entreprise']['id_entreprise']);

            // On instancie une class EntreprisesManager
            // qui vas nous servir pour supprimer le compte de l'entreprise
            $entrepriseManager = new EntreprisesManager($pdo);
            $entrepriseManager->delete_entreprise($_SESSION['entreprise']['id_entreprise']); // suppression du compte dans  la bdd


            // On supprime la session de l'entreprise
            unset($_SESSION['entreprise']);

            // On redirige vers la page de inscription
            // avec action=supprimer qui vas servir a afficher un message de confirmatoion sur la page d'inscription
            header('location:inscription.php?action=supprimer');
        } 
        
        //ici on gère la suppression d'une annonce
        if($_GET['action'] == 'supprimer-annonce'){
            $annonceManager->delete_annonce($_GET['id_annonce_clicked']); // Ici on supprime l'annonce dans la bdd
            $content .= alertMessage('success', 'Votre annonce a bien été supprimée');
        }
    }

    // Ici on récupère les annonces de l'entreprises connectée
    // Afin de les afficher sur la page
    $annoncesEntreprise = $annonceManager->recupEntrepriseAnnonces($_SESSION['entreprise']['id_entreprise']);
?>


<h1 class="text-center text-muted my-2">Bienvenue dans votre espace entreprise<br> <?= $_SESSION['entreprise']['nom']  ?></h1>
<hr>

<!-- Affichage du logo -->
<div class="d-flex justify-content-center">
    <?php echo ("<div style='width:200px;height:200px;border-radius:50%;
        background-image:url($logo);background-size: 
        cover;background-repeat:no-repeat;background-position:center'></div>"); ?>
</div>

<section class="col-md-8 mx-auto my-4 py-3">
    <!-- $content sert a afficher un message lorsqu'on a supprimer une annonce -->
    <?= $content ?>


    <!----rappel des informations de l'entreprise----->
    <h2 class="mb-2">Voici vos informations:</h2>

    <ul class="list-group col-md-8">
    <li class="list-group-item"><span class="fw-bold">Nom d'entreprise:</span> <?= $_SESSION['entreprise']['nom'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Email:</span> <?= $_SESSION['entreprise']['email'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Telephone:</span> <?= $_SESSION['entreprise']['tel'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Localisation:</span> <?= $_SESSION['entreprise']['ville'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Secteur d'activité:</span> <?= $_SESSION['entreprise']['secteur_activite'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Présentation de l'entreprise:</span> <?= $_SESSION['entreprise']['presentation'] ?></li>
    <li class="list-group-item"><a class="btn btn-dark" href="edit_espaceEntreprise.php?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>">Editer les infos de entreprise</a></li>
    <li class="list-group-item"><a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer votre compte</a></li>
    </ul>
</section>


<!-- ICI ANNONCES DE L'ENTREPRISE CONNECTEE -->
<section class="col-md-8 mx-auto m-1 py-3">

    <!-- Bouton pour ajouter une nouvelle annonce -->
    <a class="btn btn-primary mb-3" href="ajouter-annonce.php">Ajouter une annonnce</a>

    <!-- Ici on affiche un message selon si l'entreprise à déjà crée ou non des annonces -->
    <?php if(empty($annoncesEntreprise)): ?>
        <h2 class="mb-2">Vous n'avez pas encore d'annonce</h2>
    <?php else: ?>
        <h2 class="mb-2">Voici vos annonces:</h2>
    <?php endif; ?>
    

    <!-- Ici une boucle pour afficher les annonces de l'entreprise actuellement connecté -->
    <?php foreach($annoncesEntreprise as $annonce): ?>
        <?php $logo_entreprise = $annonce['logo_entreprise']; ?>
        <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
            <?php echo "<div style='max-width:100%;width:50%;height:100%;margin:0 auto;border-radius:50%;
            background-image:url($logo_entreprise);background-size: 
            contain;background-repeat:no-repeat;background-position:center'></div>" ?>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <!-- Titre -->
                    <h5 class="card-title fw-bold"><?= $annonce['titre'] ?></h5>

                    <!-- Nom de l'entreprise -->
                    <p class="card-text fs-5 mt-0 mb-1"><?= $annonce['nom_entreprise'] ?></p>

                    <div class="mb-2">
                    <!-- Localisation -->
              <span class="card-text"><i class="fa-solid fa-location-dot"></i>  <?= $annonce['localisation'] ?></span>
              |
              <!-- Contrat -->
              <span class="card-text"><i class="fa-solid fa-briefcase"></i>  <?= strtoupper($annonce['contrat']) ?></span>

                    </div>
                    
                    <!-- Description -->
                    <p class="card-text"><?= $annonce['description'] ?></p>
                    
                    <!-- Date -->
                    <p class="card-text mb-0"><small class="text-muted"><?= $annonce['date_ajout'] ?></small></p>

                    <!-- Boutons -->
                </div>
                <div class="card-footer text-muted">
                    <button onclick="supprimerAnnonce(<?= $annonce['id_annonce'] ?>)" class="btn btn-danger btn-sm">Supprimer cette annonce</button>
                </div>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
</section>

<!-- Modal suppression de compte -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">Attention cette action et irreversible !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Cette action supprimera également toutes vos annonces.
                Êtes vous sur de vouloir supprimer votre compte <?=  $_SESSION['entreprise']['nom'] ?>  ? <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                <a class="text-danger" href="?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>&action=supprimer-compte"  >Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>

<!-- Ici javascript pour confirmation de suppression du compte de l'entreprise -->
<script>
    function supprimerAnnonce(id) {
        if(confirm("Êtes vous sur de vouloir supprimer cette annonce ?")) {
            window.location.href = `?id_annonce_clicked=${id}&action=supprimer-annonce`;
        }
    }
</script>

<?php require_once "inc/footer.php"; ?>