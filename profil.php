<?php

require_once "inc/header.php";
require_once "entity/UtilisateursManager.php";

if(!utilisateurEstConnecte()){
    header('location:connexion.php');
}
$genre="";
if($_SESSION['user']['civilite'] === 'm'){
    $genre="homme";
    
}else{
    $genre="femme";
}

//suppression du compte de l'utilisateur
if (isset($_GET['action']) && $_GET['action'] == 'supprimer') {
    $utilisateurManager = new UtilisateursManager($pdo);
    $utilisateurManager->delete_utilisateur($_SESSION['user']['id_utilisateur']);
    unset($_SESSION['user']);
    header('location:inscription.php');
}
?>


<h1 class="text-center text-muted">Bienvenue <?= $_SESSION['user']['nom'] ." ". $_SESSION['user']['prenom'] ?></h1>
<hr>





Voici vos informations: <br>
Votre nom: <?= $_SESSION['user']['nom'] ?> <br>
Votre prenom: <?= $_SESSION['user']['prenom'] ?> <br>
Votre email: <?= $_SESSION['user']['email'] ?> <br>
Votre téléphone: <?= $_SESSION['user']['tel'] ?> <br>
genre: <?= $genre ?> <br>
Votre ville: <?= $_SESSION['user']['ville'] ?> <br>


<a href="edit_profil_user.php?id=<?= $_SESSION['user']['id_utilisateur']?>">Editer mon profil</a>
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
                etes vous sur de vouloir supprimer votre compte <?=  $_SESSION['user']['nom'] . " " . $_SESSION['user']['prenom'] ?>  ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                <a class="text-danger" href="?id=<?= $_SESSION['user']['id_utilisateur'] ?>&action=supprimer" >Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>





<?php require_once "inc/footer.php";?>