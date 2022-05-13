<?php 
require_once 'inc/header.php'; 
    /*
    *  CONFIGURE EVERYTHING HERE
    */

    // an email address that will be in the From field of the email.
    $from = 'Job Annonce';

    // an email address that will receive the email with the output of the form
    $sendTo = 'Demo contact form <j.annonce.2022@gmail.com>';

    // subject of the email
    $subject = 'Nouvaux message de Job Annonce';

    // form field names and their translations.
    // array variable name => Text to appear in the email
    $fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); 

    // message that will be displayed when everything is OK :)
    $okMessage = '
    Message envoyé avec succès. Merci, nous vous répondrons trés bientôt!';

    // If something goes wrong, we will display this message.
    $errorMessage = 'Une erreur s\'est produite lors de la soumission du formulaire. Veuillez réessayer plus tard';

    /*
    *  LET'S DO THE SENDING
    */

    // if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
    error_reporting(E_ALL & ~E_NOTICE);

    if($_POST){
        try
        {
    
            if(count($_POST) == 0) throw new \Exception('Form is empty');
                    
            $emailText = "Vous avez un nouveaux message\n=============================\n";
    
            foreach ($_POST as $key => $value) {
                // If the field exists in the $fields array, include it in the email 
                if (isset($fields[$key])) {
                    $emailText .= "$fields[$key]: $value\n";
                }
            }
    
            // All the neccessary headers for the email.
            $headers = array('Content-Type: text/plain; charset="UTF-8";',
                'From: ' . $from,
                'Reply-To: ' . $from,
                'Return-Path: ' . $from,
            );
            
            // Send email
            mail($sendTo, $subject, $emailText, implode("\n", $headers));
    
            $responseArray = array('type' => 'success', 'message' => $okMessage);
    
            // Affiche le message de réussite au dessus du formulaire
            $content .= alertMessage('success', $okMessage);
        }
        catch (\Exception $e)
        {
            $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    
            // Affiche le message d'erreur au dessus du formulaire
            $content .= alertMessage('danger', $errorMessage);
        }

        // if requested by AJAX request return JSON response
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $encoded = json_encode($responseArray);
    
            header('Content-Type: application/json');
    
            echo $encoded;
        }
        // else just display the message
        else {
            //echo $responseArray['message'];
        }
    }
    

?>

<h1 class="text-center my-3" >Contactez nous</h1>

<section class="col-md-6 mx-auto m-1 py-3">
<form action="contact.php" method="post" id="form-contact">
    <?= $content; ?>
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
            <textarea class="form-control"  name="message" id="message"  placeholder="Entrez votre message..." ></textarea>
        </div>

        <div class="mt-2">
            <button class="btn btn-dark">Envoyer</button>
        </div>
</form>
</section>





<?php require_once 'inc/footer.php'; ?>