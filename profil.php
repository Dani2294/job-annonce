<?php

require_once "inc/header.php";

if(!utilisateurEstConnecte()){
    header('location:connexion.php');
}
$genre="";
if($_SESSION['user']['civilite'] === 'm'){
    $genre="homme";
    
}else{
    $genre="femme";
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
 





<?php require_once "inc/footer.php";?>