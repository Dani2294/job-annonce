<?php
  require_once 'inc/bdd.php';
  require_once 'inc/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>JOB ANONCE</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">JOB ANNONCE  <i class="fa-solid fa-network-wired"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Menu
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="inscription.php">Inscription</a></li>

            <!-- On affiche connexion ou deconnexion selon si un utilisateur ou une entreprise est connecté -->
            <?php if(!utilisateurEstConnecte() && !entrepriseEstConnecte()): ?>
            <li><a class="dropdown-item" href="connexion.php">Connexion</a></li>
            <?php else: ?>
            <li><a class="dropdown-item" href="connexion.php?action=deconnexion">Déconnexion</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- On affiche Mon profil ou Espace entreprise selon si c'est un utilisateur ou une entreprise qui est connecté -->
        <?php if(utilisateurEstConnecte()): ?>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="profil.php">Mon profil</a>
        </li>
        <?php elseif(entrepriseEstConnecte()): ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="espaceEntreprise.php">Espace Entreprise</a>
        </li>
        <?php endif; ?>

        
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contact.php">Contactez-nous</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
