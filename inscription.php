<?php require_once 'inc/header.php'; ?>




<h1 class="text-center my-4">Inscription</h1>
<section class="col-md-6 mx-auto m-1">
    <?= $content ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nom">Nom</label>
        <input class="form-control" type="text" name="nom" id="nom" value="" placeholder="Entrer votre nom..." />

        <label for="prenom">Prenom</label>
        <input class="form-control" type="text" name="prenom" id="prenom" value="" placeholder="Entrer votre prenom..." />
        
        <label for="email">Email</label>
        <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />

        <label for="mdp">Mot de passe</label>
        <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Entrer votre mdp..." />

        <label for="tel">Telephone</label>
        <input class="form-control" type="text" name="tel" id="tel" value="" placeholder="Entrer votre tel..." />

        <br>

        <label for="genre">Genre</label>
        <select class="form-control" name="genre" id="genre">
            <option value="m">Homme</option>
            <option value="f">Femme</option>
        </select>

        <div class="mt-2">
            <button class="btn btn-dark">Inscription</button>
        </div>
    </form>
</section>




<?php require_once 'inc/footer.php'; ?>