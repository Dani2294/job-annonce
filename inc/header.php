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
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">JOB ANNONCE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Menu
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="inscription.php">Inscription</a></li>
            <?php if(!utilisateurEstConnecte() && !entrepriseEstConnecte()): ?>
            <li><a class="dropdown-item" href="connexion.php">Connexion</a></li>
            <?php else: ?>
            <li><a class="dropdown-item" href="connexion.php?action=deconnexion">Déconnexion</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <?php if(utilisateurEstConnecte()): ?>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="profil.php">Mon profil</a>
        </li>
        <?php elseif(entrepriseEstConnecte()): ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="administration.php">Espace Entreprise</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="contact.php">Contactez-nous</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
