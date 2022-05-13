<?php

class Entreprise
{
    // proprietes

    // Tableau d'erreurs qui vas nous servir pour récupérer les erreurs
    private $erreurs = [];

    private $nom;
    private $email;
    private $mdp;
    private $tel;
    private $ville;
    private $secteur_activite;
    private $presentation;
    private $logo;

    // constructeur
    public function __construct(array $donnees){
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }

    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            // Execute la protection des champs uniquement si la $valeur n'est pas de type array
            // Car la $valeur du logo est de type array lorsqu'on la reçoit
            if(!gettype($valeur) == 'array'){
                $valeur = htmlspecialchars($valeur);
                $valeur = addslashes($valeur);
            }

            $methodeSetters = 'set' . ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    // =============== LES SETTERS ===============
    public function setNom(string $nom)
    {
        if (!empty($nom)) {
                $this->nom = $nom;
        } else {
            $this->erreurs[] = 'Le <b>nom</b> est obligatoire';
        }
    }

    public function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            $this->erreurs[] = "<b>L'email</b> n'est pas valide";
        }
    }

    public function setMdp(string $mdp)
    {
        if(!empty($mdp)){
            if(strlen($mdp) < 5){
                $this->erreurs[] = 'Le <b>mot de passe</b> doit contenir au moins 5 caractères';
            } else {
                $cryptedMpd = password_hash($mdp, PASSWORD_DEFAULT);
                $this->mdp = $cryptedMpd;
            }
        } else {
            $this->erreurs[] = 'Le <b>mot de passe</b> est obligatoire';
        }
    }

    public function setTel(string $tel)
    {
        if (!empty($tel)) {
            $this->tel = $tel;
        } else {
            $this->erreurs[] = 'Le <b>numéro de téléphone</b> est obligatoire';
        }
    }

    public function setVille(string $ville)
    {
        if (!empty($ville)) {
            $this->ville = $ville;
        } else {
            $this->erreurs[] = 'La <b>ville</b> est obligatoire';
        }
    }

    public function setSecteur_activite(string $secteur_activite)
    {
        if (!empty($secteur_activite)) {
            $this->secteur_activite = $secteur_activite;
        } else {
            $this->erreurs[] = "Le <b>secteur d'activité</b> est obligatoire";
        }
    }

    public function setPresentation(string $presentation)
    {
        if (!empty($presentation)) {
            $this->presentation = $presentation;
        } else {
            $this->erreurs[] = 'La <b>présentation de votre entreprise</b> est obligatoire';
        }
    }

    public function setLogo(array $logo)
    {
        if (!empty($logo)) {
            // Concatenation du nom de l'entreprise et du nom du logo/image
            // fonction de str_replace() permet enlever les espaces dans le nom de l'entreprise
            // car il ne faut pas d'espaces dans une url
            $nom_logo = str_replace(' ', '', $this->getNom())  . '-' . $logo['name'];

            // On affecte l'url de la logo dans la variable $logo_bdd (chemin du logo)
            $logo_bdd = URL . "logo/$nom_logo";

            // On affecte le chemin du logo dans la variable $logo_dossier
            $logo_dossier = RACINE_SITE . "logo/$nom_logo";

            // On déplace/copy le logo dans le dossier logo grâce a la fonction copy()
            copy($logo['tmp_name'], $logo_dossier);

            // On affecte l'url du logo dans la propriété $logo
            $this->logo = $logo_bdd;
        }
    }

    // =============== LES GETTERS ===============
    public function getNom()
    {
        return $this->nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function getSecteur_activite()
    {
        return $this->secteur_activite;
    }

    public function getPresentation()
    {
        return $this->presentation;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    // methodes qui recupere les erreurs
    public function getErreurs()
    {
        return $this->erreurs;
    }

    // methodes qui verifie si l'entreprise est valide
    public function isEntrepriseValide()
    {
        // verification: si le tableau d'erreur est vide
        return empty($this->erreurs);
    }
}