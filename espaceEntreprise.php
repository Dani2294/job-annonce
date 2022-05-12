<?php

require_once "inc/header.php";
require_once "entity/EntreprisesManager.php";
//si entreprise et utilisateur n'est pas connecte il est rediriger a connexion.php 
if (!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()) {
    header('location:connexion.php');
}

//affectation de url du logo dans la variable logo
$logo = $_SESSION['entreprise']['logo'];

//suppression du compte de l'entreprise
if (isset($_GET['action']) && $_GET['action'] == 'supprimer') {
    $entrepriseManager = new EntreprisesManager($pdo);
    $entrepriseManager->delete_entreprise($_SESSION['entreprise']['id_entreprise']);
    unset($_SESSION['entreprise']);
    header('location:inscription.php');
}
?>


<h1 class="text-center text-muted">Bienvenue <?= $_SESSION['entreprise']['nom']  ?></h1>
<hr>

<div class="d-flex justify-content-center">
    <?php echo ("<div style='width:200px;height:200px;border-radius:0%;
        background-image:url($logo);background-size: 
        cover;background-repeat:no-repeat;background-position:center'></div>"); ?>

</div>

<a href="ajouter-annonce.php">Ajouter une annonnce</a>

<!----rappel des informations de l'entreprise----->
Voici vos informations: <br>
Votre nom: <?= $_SESSION['entreprise']['nom'] ?> <br>

Votre email: <?= $_SESSION['entreprise']['email'] ?> <br>
Votre téléphone: <?= $_SESSION['entreprise']['tel'] ?> <br>

Votre ville: <?= $_SESSION['entreprise']['ville'] ?> <br>
Votre secteur d'activite: <?= $_SESSION['entreprise']['secteur_activite'] ?> <br>
Votre presentation: <?= $_SESSION['entreprise']['presentation'] ?> <br>



<a href="edit_espaceEntreprise.php?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>">Editer les infos de entreprise</a>
<br>
<a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer votre compte</a>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">Attention cette action et irreversible !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                etes vous sur de vouloir supprimer votre compte <?=  $_SESSION['entreprise']['nom'] ?>  ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                <a class="text-danger" href="?id=<?= $_SESSION['entreprise']['id_entreprise'] ?>&action=supprimer" >Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>






<?php require_once "inc/footer.php"; ?>