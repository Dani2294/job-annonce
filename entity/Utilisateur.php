<?php

class Utilisateur
{
    // proprietes
    private $erreurs = [];
    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $tel;
    private $civilite;
    private $ville;

    // creation de constantes d invalidité
    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const EMAIL_INVALIDE = 3;

     // creation du constructeur
    public function __construct(array $donnees)
    {
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }

    // fonction hydrater qui va hydrater les données de l utilisateur dans les proprietes grace au setteur
    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $valeur = htmlspecialchars($valeur);
            $valeur = addslashes($valeur);

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

    public function setPrenom(string $prenom)
    {
        if (!empty($prenom)) {
            $this->prenom = $prenom;
        }
    }

    public function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            // self fait reference a la classe
            // si le paramettre n'es pas un email on ajoute une erreur dans notre tableau d'erreur
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
        $this->tel = $tel;
    }

    public function setCivilite(string $civilite)
    {
        $this->civilite = $civilite;
    }

    public function setVille(string $ville)
    {
        $this->ville = $ville;
    }

    // getters
    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
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

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function getVille()
    {
        return $this->ville;
    }


    // fonction qui recupere les erreurs
    public function getErreurs()
    {
        return $this->erreurs;
    }

    // fonction qui verifie si l utilisateur est valide
    public function isUserValide()
    {
        // verification: si le tableau d'erreur est vide
        return empty($this->erreurs);
    }
}