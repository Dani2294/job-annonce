<?php

    require_once "inc/header.php";
    require_once "entity/EntreprisesManager.php";
    require_once "entity/AnnoncesManager.php";
    //si entreprise et utilisateur n'est pas connecte il est rediriger a connexion.php 
    if (!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()) {
        header('location:connexion.php');
    }


    $id_annonce_clicked;

    $annonceManager = new AnnoncesManager($pdo);
    
    //affectation de url du logo dans la variable logo
    $logo = $_SESSION['entreprise']['logo'];
    
    //suppression du compte de l'entreprise
    if (isset($_GET['action'])) {
        if($_GET['action'] == 'supprimer-compte'){
            $entrepriseManager = new EntreprisesManager($pdo);
            $entrepriseManager->delete_entreprise($_SESSION['entreprise']['id_entreprise']);
            unset($_SESSION['entreprise']);
            header('location:inscription.php');
        } 
        
        if($_GET['action'] && $_GET['action'] == 'supprimer-annonce'){
            //var_dump($_GET['id_annonce_clicked']);
            $annonceManager->delete_annonce($_GET['id_annonce_clicked']);
            $content .= alertMessage('success', 'Votre annonce a bien été supprimée');
        }
    }

    // Récuperer les annonces de l'entreprises connectée
    $annoncesEntreprise = $annonceManager->recupEntrepriseAnnonces($_SESSION['entreprise']['id_entreprise']);

    //var_dump($annoncesEntreprise);
?>


<h1 class="text-center text-muted my-2">Bienvenue <?= $_SESSION['entreprise']['nom']  ?></h1>
<hr>

<div class="d-flex justify-content-center">
    <?php echo ("<div style='width:200px;height:200px;border-radius:0%;
        background-image:url($logo);background-size: 
        cover;background-repeat:no-repeat;background-position:center'></div>"); ?>
</div>

<section class="col-md-8 mx-auto my-4 py-3">
    <?= $content ?>

    <a class="btn btn-primary mb-3" href="ajouter-annonce.php">Ajouter une annonnce</a>

    <!----rappel des informations de l'entreprise----->
    <h2 class="mb-2">Voici vos informations:</h2>

    <ul class="list-group col-md-8">
    <li class="list-group-item"><span class="fw-bold">Nom d'entreprise:</span> <?= $_SESSION['entreprise']['nom'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Email:</span> <?= $_SESSION['entreprise']['email'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Telephone:</span> <?= $_SESSION['entreprise']['tel'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Localisation:</span> <?= $_SESSION['entreprise']['ville'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Secteur d'activité:</span> <?= $_SESSION['entreprise']['secteur_activite'] ?></li>
    <li class="list-group-item"><span class="fw-bold">Présentation de l'entreprise:</span> <?= $_SESSION['entreprise']['presentation'] ?></li>
    <li class="list-group-item"><a href="edit_espaceEntreprise.php?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>">Editer les infos de entreprise</a></li>
    <li class="list-group-item"><a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer votre compte</a></li>
    </ul>
</section>


<!-- ICI ANNONCES DE L'ENTREPRISE CONNECTEE -->
<section class="col-md-8 mx-auto m-1 py-3">
    <h2 class="mb-2">Voici vos annonces:</h2>
    <?php foreach($annoncesEntreprise as $annonce): ?>
        <?php $logo_entreprise = $annonce['logo_entreprise']; ?>
        <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
            <?php echo "<div style='max-width:100%;width:50%;height:100%;margin:0 auto;
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
                    <span class="card-text"><?= $annonce['localisation'] ?></span>
                    |
                    <!-- Contrat -->
                    <span class="card-text"><?= $annonce['contrat'] ?></span>
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
                Êtes vous sur de vouloir supprimer votre compte <?=  $_SESSION['entreprise']['nom'] ?>  ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                <a class="text-danger" href="?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>&action=supprimer"  >Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>

<script>
    function supprimerAnnonce(id) {
        if(confirm("Êtes vous sur de vouloir supprimer cette annonce ?")) {
            window.location.href = `?id_annonce_clicked=${id}&action=supprimer-annonce`;
        }
        //document.getElementById("btn-supp-annonce").href = "?action=supprimer-annonce";
    }
</script>

<?php require_once "inc/footer.php"; ?>