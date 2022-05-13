<?php 
    //a modifier
    require_once 'inc/header.php'; 
    require_once 'entity/Entreprise.php';
    require_once 'entity/EntreprisesManager.php';

    // Si l'entreprise n'est pas connectée et l'utilisateur est ou n'est pas connecte 
    // on redirige vers la page de connexion
    // Seulement une entreprise qui est connecté qui peut avoir accès a cette page
    if(!entrepriseEstConnecte() && !utilisateurEstConnecte() || utilisateurEstConnecte()){
        header('location:connexion.php');
    }

    // On instancie une class EntreprisesManager
    // qui va servir à update les donnees de l'entreprise
    $entrepriseManager = new EntreprisesManager($pdo);


    if($_POST){
        // On instancie une nouvelle class Entreprise
        $entreprise = new Entreprise([
            'nom' => $_POST['nom'],
            'email' => $_POST['email'],
            'mdp' => $_POST['mdp'],
            'tel' => $_POST['tel'],
            'ville' => $_POST['ville'],
            'secteur_activite' => $_POST['secteur_activite'],
            'presentation' => $_POST['presentation'],
        ]);

        // S'il n'y a pas d'erreur dans le formulaire
        // on fait une mise à jour des donnees du formulaire dans la base de donne
        if($entreprise->isEntrepriseValide()){
            $entrepriseManager->update_entreprise($_SESSION['entreprise']['id_entreprise'],$_POST); // Ici MAJ des donnnees de l'entreprise dans la bdd

            // On recupere les dernières modifications apportées à l'entreprise dans la bdd
            $currEntreprise = $entrepriseManager->afficherEntreprise($_POST['email']);

            // On affecte les infos de l'entreprise dans une session entreprise
            $_SESSION['entreprise']['id_entreprise'] = $currEntreprise['id_entreprise'];
            $_SESSION['entreprise']['nom'] = $currEntreprise['nom'];
            $_SESSION['entreprise']['email'] = $currEntreprise['email'];
            $_SESSION['entreprise']['tel'] = $currEntreprise['tel'];
            $_SESSION['entreprise']['ville'] = $currEntreprise['ville'];
            $_SESSION['entreprise']['secteur_activite'] = $currEntreprise['secteur_activite'];
            $_SESSION['entreprise']['presentation'] = $currEntreprise['presentation'];
            $_SESSION['entreprise']['logo'] = $currEntreprise['logo'];

            $content .= alertMessage("success","Les modifications ont bien été enregistrées");
        } else {
            // ici on récupère les erreurs si il y en a
            $erreurs = $entreprise->getErreurs();

            // ici on affiche les erreurs avec une boucle foreach
            foreach($erreurs as $erreur){
                $content .= alertMessage('danger', $erreur);
            }
        }
    }
?>

<h1 class="text-center my-3" >Editer le profil de votre entreprise</h1>

<a href="espaceEntreprise.php" class="btn btn-dark ms-4">Retour sur espace entreprise</a>

<section class="col-md-6 mx-auto m-1 py-3">
    
    
    <!-- Formulaire modification utilisateur -->
    <form action="" method="post" id="form-entreprise">

        <?= $content; ?>
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" value="<?= $_SESSION['entreprise']['nom']?>" placeholder="Entrer votre nom..." />
        </div>


        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= $_SESSION['entreprise']['email']?>" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe (entrez le même mdp que lors de l'inscription. PS: on a pas eu le temps de gérer le nouveau mdp 😅)</label>
            <input class="form-control" type="password" name="mdp" id="mdp"  placeholder="Entrer votre mot de passe..." />
        </div>

        <div class="mb-3">
            <label for="tel">Tel</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="<?= $_SESSION['entreprise']['tel']?>" placeholder="Entrer votre numero de telephone..." />
        </div>


        <div class="mb-3">
            <label for="ville">Ville</label>
            <input class="form-control" type="text" name="ville" id="ville" value="<?= $_SESSION['entreprise']['ville']?>" placeholder="Entrer votre ville..." />
        </div>


        <div class="mb-3">
            <label for="secteur_activite">Secteur d'activité</label>
            <input class="form-control" type="text" name="secteur_activite" id="secteur_activite" value="<?= $_SESSION['entreprise']['secteur_activite']?>" placeholder="Entrer votre secteur d'activité" />
        </div>


        <div class="mb-3">
            <label for="presentation">Presentation</label>
            <textarea class="form-control"  name="presentation" id="presentation"  placeholder="Decrivez votre entreprise" >
            <?= $_SESSION['entreprise']['presentation']?></textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Enregistrer modifications</button>
        </div>
    </form>

</section>

<?php require_once 'inc/footer.php'; ?>