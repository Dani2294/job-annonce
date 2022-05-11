<?php

class Entreprise
{
    // proprietes
    private $erreurs = [];
    private $nom;
    private $email;
    private $mdp;
    private $tel;
    private $ville;
    private $secteur_activite;
    private $presentation;
    private $logo;

    // creation de constantes d invalidité
    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const EMAIL_INVALIDE = 3;

    // constructeur
    public function __construct(array $donnees){
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }

    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            if(!gettype($valeur) == 'array'){
                $valeur = htmlspecialchars($valeur);
                $valeur = addslashes($valeur);
            }

            $methodeSetters = 'set' . ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    // setters
    public function setNom(string $nom)
    {
        if (!empty($nom)) {
            $this->nom = $nom;
        }
    }

    public function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        }
    }

    public function setMdp(string $mdp)
    {
        if(!empty($mdp)){
            $cryptedMpd = password_hash($mdp, PASSWORD_DEFAULT);
            $this->mdp = $cryptedMpd;
        }
    }

    public function setTel(string $tel)
    {
        if (!empty($tel)) {
            $this->tel = $tel;
        }
    }

    public function setVille(string $ville)
    {
        if (!empty($ville)) {
            $this->ville = $ville;
        }
    }

    public function setSecteur_activite(string $secteur_activite)
    {
        if (!empty($secteur_activite)) {
            $this->secteur_activite = $secteur_activite;
        }
    }

    public function setPresentation(string $presentation)
    {
        if (!empty($presentation)) {
            $this->presentation = $presentation;
        }
    }

    public function setLogo(array $logo)
    {
        if (!empty($logo)) {
            // Concatenation du pseudo et du nom du logo
            // fonction de str_replace() permet enlever les espaces dans le nom
            $nom_logo = str_replace(' ', '', $this->getNom())  . '-' . $logo['name'];

            // On affecte l'url de la logo dans la variable $logo_bdd (chemin du logo)
            $logo_bdd = URL . "logo/$nom_logo";

            // On affecte le chemin du logo dans la variable $logo_dossier
            $logo_dossier = RACINE_SITE . "logo/$nom_logo";

            // On déplace/copy le logo dans le dossier logo grâce a la fonction copy()
            copy($logo['tmp_name'], $logo_dossier);
            $this->logo = $logo_bdd;
        }
    }

    // getters
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

    // fonction qui recupere les erreurs
    public function getErreurs()
    {
        return $this->erreurs;
    }

    // fonction qui verifie si l utilisateur est valide
    public function isEntrepriseValide()
    {
        // verification: si le tableau d'erreur est vide
        return empty($this->erreurs);
    }
}