<?php 
    require_once 'inc/header.php';
    require_once 'entity/AnnoncesManager.php';

    $annonceManager = new AnnoncesManager($pdo);

    $donnees = $annonceManager->recupAllAnnonces();

    var_dump($donnees);

?>



<h1>Toutes annonces</h1>

<section class="col-md-8 mx-auto m-1 py-3">
<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="..." class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>
</div>
</section>




<?php require_once 'inc/footer.php'; ?>