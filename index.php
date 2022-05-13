<?php 
    require_once 'inc/header.php';
    require_once 'entity/AnnoncesManager.php';

    $annonceManager = new AnnoncesManager($pdo);

    $donnees = $annonceManager->recupAllAnnonces();
    //var_dump($donnees);

    // Code pour le filtre de recherche
    if($_GET){
      if(isset($_GET['recherche']) && !empty($_GET['recherche'])){
            $recherche = $_GET['recherche'];
            $donnees = $annonceManager->rechercheAnnonces($recherche);
            
        }
    }
?>



<section class="col-md-6 mx-auto m-1 py-3">
  <h1 class="my-4">Toutes les annonces</h1>

  <!-- =========== ZONE FILTRE RECHERCHE ============= -->
  <div class="mb-4">
    <form class="d-flex" method="get">
        <label for="recherche" class="d-block">Rechercher une annonce</label>
        <input id="recherche" name="recherche" class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="rechercher une anonce">
        <button class="btn btn-outline-success" type="submit">Rechercher</button>
      </form>
  </div>
  
  <!-- =========== FIN ZONE FILTRE RECHERCHE ============= -->

  <!-- Boucle foreach pour afficher toutes les annonces -->
  <?php foreach($donnees as $annonce): ?>
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
        </div>
      </div>
    </div>
<?php endforeach; ?>
</section>




<?php require_once 'inc/footer.php'; ?>