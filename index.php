<?php 
    require_once 'inc/header.php';
    require_once 'entity/AnnoncesManager.php';

    // On instancie une classe AnnoncesManager
    // qui vas nous permettre de récupérer les annonces grace aux requêtes SQL
    // et de les afficher
    $annonceManager = new AnnoncesManager($pdo);

    // On récupère toutes les annonces que l'on stock dans la variables $donnees
    $donnees = $annonceManager->recupAllAnnonces();

    // Ici le code pour le filtre de recherche
    if($_GET){
      if(isset($_GET['recherche']) && !empty($_GET['recherche'])){
            // ici on récupère la valeur de la recherche
            $recherche = $_GET['recherche'];

            // ici on récupère toutes les annonces qui contiennent la valeur de la recherche
            // dans leur titre
            $donnees = $annonceManager->rechercheAnnonces($recherche);
        }
    }
?>



<section class="col-md-6 mx-auto m-1 py-3">
  <h1 class="fw-bold my-4">Bienvenue sur <span class="text-primary" >JOB ANNONCE !</span> le site qui vas booster votre recherche d'emplois ⚡️</h1>

  <!-- =========== ZONE FILTRE RECHERCHE ============= -->
  <div class="mb-4">
    <form method="get">
        <label for="recherche" class="d-block fs-5 mb-1">Rechercher une annonce</label>
        <div class="d-flex">
          <input id="recherche" name="recherche" class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="rechercher une anonce">
          <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </div>
      </form>
  </div>
  <!-- =========== FIN ZONE FILTRE RECHERCHE ============= -->


    <!-- ici on affiche le nombre de résultat de la recherche -->
    <?php if(isset($_GET['recherche']) && !empty($_GET['recherche'])): ?>
      <p>Nous avons trouvé <?= count($donnees) ?> résultat(s) pour votre recherche</p>
    <?php endif; ?>


  <!-- Ici une boucle foreach pour afficher toutes les annonces -->
  <?php foreach($donnees as $annonce): ?>
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
            
            <!-- Date d'ajout de l'annonce -->
            <p class="card-text"><small class="text-muted"><?= $annonce['date_ajout'] ?></small></p>

          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
</section>




<?php require_once 'inc/footer.php'; ?>