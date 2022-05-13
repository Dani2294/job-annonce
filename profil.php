<?php

    require_once "inc/header.php";
    require_once "entity/UtilisateursManager.php";

    // si entreprise et utilisateur n'est pas connecte il est rediriger vers connexion.php
    // Seul un utilisateur connecté peut avoir accès a cette page
    if(!utilisateurEstConnecte() && !entrepriseEstConnecte() || entrepriseEstConnecte())
    {
        header('location:connexion.php');
    }

    // On affiche 'homme' ou 'femme'
    // on fonction de la valeur de la civilité (soit 'm' soit 'f')
    $genre="";
    if($_SESSION['user']['civilite'] === 'm'){
        $genre="homme";
        
    }else{
        $genre="femme";
    }

    //suppression du compte de l'utilisateur
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer') {
        // On instancie une nouvelle instance de la classe UtilisateursManager
        // Qui va nous permettre de supprimer l'utilisateur
        $utilisateurManager = new UtilisateursManager($pdo);
        $utilisateurManager->delete_utilisateur($_SESSION['user']['id_utilisateur']); // suppression de la bdd

        // On supprime les données de l'utilisateur dans la session
        unset($_SESSION['user']);

        // On redigire vers la page d'inscription
        // avec action=supprimer qui vas servir a afficher un message de confirmatoion sur la page d'inscription
        header('location:inscription.php?action=supprimer');
    }
?>





<h1 class="text-center text-muted">Bienvenue <?= $_SESSION['user']['nom'] ." ". $_SESSION['user']['prenom'] ?></h1>
<hr>

<section class="col-md-8 mx-auto my-4 py-3">
    <?= $content ?>

    <!----rappel des informations de l'entreprise----->
    <h2 class="mb-2">Voici vos informations:</h2>

    <ul class="list-group col-md-8">
        <li class="list-group-item"><span class="fw-bold">Nom:</span> <?= $_SESSION['user']['nom'] ?></li>
        <li class="list-group-item"><span class="fw-bold">Prenom:</span> <?= $_SESSION['user']['prenom'] ?></li>
        <li class="list-group-item"><span class="fw-bold">Email:</span> <?= $_SESSION['user']['email'] ?> </li>
        <li class="list-group-item"><span class="fw-bold">Telephone:</span> <?= $_SESSION['user']['tel'] ?></li>
        <li class="list-group-item"><span class="fw-bold">Genre:</span> <?= $genre ?></li>
        <li class="list-group-item"><span class="fw-bold">Ville:</span> <?= $_SESSION['user']['ville'] ?></li>
        <li class="list-group-item"><a class="btn btn-dark" href="edit_profil_user.php?id=<?= $_SESSION['user']['id_utilisateur']?>">Editer mon profil</a></li>
        <li class="list-group-item"><a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer votre compte</a></li>
    </ul>
</section>

<!-- Modal de suppression de compte -->
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

                <!-- Grace au paremetre dans l'url : id_utilisateur et action supprimer,
                on va supprimer le compte de l'utilisateur -->
                <a class="text-danger" href="?id=<?= $_SESSION['user']['id_utilisateur'] ?>&action=supprimer" >Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>





<?php require_once "inc/footer.php";?>