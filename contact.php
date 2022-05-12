<?php 

/* Page: contact.php */
//mettez ici votre adresse mail
$VotreAdresseMail="j.annonce.2022@gmail.com";
// si le bouton "Envoyer" est cliqué
if(isset($_POST['envoyer'])) {
    //on vérifie que le champ mail est correctement rempli
    if(empty($_POST['email'])) {
        echo "Le champ email est vide";
    } else {
        //on vérifie que l'adresse est correcte
        if(!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,}$#i",$_POST['email'])){
            echo "L'adresse email entrée est incorrecte";
        }else{
            //on vérifie que le champ sujet est correctement rempli
            if(empty($_POST['sujet'])) {
                echo "Le champ sujet est vide";
            }else{
                //on vérifie que le champ message n'est pas vide
                if(empty($_POST['message'])) {
                    echo "Le champ message est vide";
                }else{
                    //tout est correctement renseigné, on envoi le mail
                    //on renseigne les entêtes de la fonction mail de PHP
                    $Entetes = "MIME-Version: 1.0\r\n";
                    $Entetes .= "Content-type: text/html; charset=UTF-8\r\n";
                    $Entetes .= "From: job-annonce <".$_POST['email'].">\r\n";//de préférence une adresse avec le même domaine de là où, vous utilisez ce code, cela permet un envoie quasi certain jusqu'au destinataire
                    $Entetes .= "Reply-To: job-annonce <".$_POST['email'].">\r\n";
                    //on prépare les champs:
                    $Mail=$_POST['email']; 
                    $Sujet='=?UTF-8?B?'.base64_encode($_POST['sujet']).'?=';//Cet encodage (base64_encode) est fait pour permettre aux informations binaires d'être manipulées par les systèmes qui ne gèrent pas correctement les 8 bits (=?UTF-8?B? est une norme afin de transmettre correctement les caractères de la chaine)
                    $Message=htmlentities($_POST['message'],ENT_QUOTES,"UTF-8");//htmlentities() converti tous les accents en entités HTML, ENT_QUOTES Convertit en + les guillemets doubles et les guillemets simples, en entités HTML
                    //en fin, on envoi le mail
                    if(mail($VotreAdresseMail,$Sujet,nl2br($Message),$Entetes)){//la fonction nl2br permet de conserver les sauts de ligne et la fonction base64_encode de conserver les accents dans le titre
                        echo "Le mail à été envoyé avec succès!";
                    } else {
                        echo "Une erreur est survenue, le mail n'a pas été envoyé";
                    }
                }
            }
        }
    }
}



require_once 'inc/header.php'; ?>

<h1 class="text-center my-3" >Contacter nous</h1>

<section class="col-md-6 mx-auto m-1 py-3">
<form action="post" method="post" id="form-contact">
<!-- <?= $content; ?> -->
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" value="" placeholder="Entrer votre nom..." />
        </div>

        <div class="mb-3">
            <label for="prenom">Prenom</label>
            <input class="form-control" type="text" name="prenom" id="prenom" value="" placeholder="Entrer votre prenom..." />
        </div>

        <div class="mb-3">
            <label for="telephone">Téléphone</label>
            <input class="form-control" type="tel" name="tel" id="tel" value="" placeholder="Entrer votre numero de telephone..." />
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="" placeholder="Entrer votre email..." />
        </div>

        <div class="mb-3">
            <label for="sujet">Sujet</label>
            <input class="form-control" type="text" name="sujet" id="sujet" value="" placeholder="Sujet de votre message..." />
        </div>

        <div class="mb-3">
            <label for="message">Message</label>
            <textarea class="form-control"  name="message" id="message"  placeholder="Entrez votre message..." >
            </textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Envoyer</button>
        </div>
</form>
</section>





<?php require_once 'inc/footer.php'; ?>