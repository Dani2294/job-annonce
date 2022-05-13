<?php

    // Verifie que l'internaute est bien connecté
    function utilisateurEstConnecte(){
        if(!isset($_SESSION['user'])){
            return false;
        }else{
            return true;
        }
    }

    // verifier si l'entreprise est connecté
    function entrepriseEstConnecte(){
        if(!isset($_SESSION['entreprise'])){
            return false;
        }else{
            return true;
        }
    }

    // fonction pour afficher un messsage d'alert
    function alertMessage($type, $message){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }
?>