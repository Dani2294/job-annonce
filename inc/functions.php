<?php

// Verifie que l'internaute est bien connecté
function utilisateurEstConnecte(){
    if(!isset($_SESSION['user'])){
        return false;
    }else{
        return true;
    }
}

// verifier si l'internaute est connecter et est admin
function entrepriseEstConnecte(){
    if(!isset($_SESSION['entreprise'])){
        return false;
    }else{
        return true;
    }
}

// fonction pour afficher un messsage
function alertMessage($type, $message){
    return '<div class="alert alert-'.$type.'">'.$message.'</div>';
}
?>