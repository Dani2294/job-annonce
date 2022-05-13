<?php

class Annonce
{
   // proprietes

   // Tableau d'erreurs qui vas nous servir pour récupérer les erreurs
    private $erreurs = [];

    private $id_entreprise; 
    private $titre;
    private $nom_entreprise;
    private $description;
    private $localisation;
    private $contrat;
    private $date_ajout;
    private $logo_entreprise;

   //constructeur
    public function __construct(array $donnees){
        // appel la methode hydrater
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }


    // methode hydrater qui va hydrater les données de l'utilisateur 
    // dans les proprietes grace au setteur
    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            // protection contre les caractères spéciaux
            $valeur = htmlspecialchars($valeur);
            $valeur = addslashes($valeur);
            
            $methodeSetters = 'set' . ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    // =============== LES SETTERS ===============

    public function setId_entreprise(int $id_entreprise)
    {
        if (!empty($id_entreprise)) {
            $this->id_entreprise = $id_entreprise;
        }
    }

    public function setTitre(string $titre)
    {
        if (!empty($titre)) {
            $this->titre = $titre;
        } else {
            $this->erreurs[] = 'Le <b>titre</b> est obligatoire';
        }
    }

    public function setNom_entreprise(string $nom_entreprise)
    {
        if (!empty($nom_entreprise)) {
            $this->nom_entreprise = $nom_entreprise;
        }
    }

    public function setDescription(string $description)
    {
        if (!empty($description)) {
            $this->description = $description;
        } else {
            $this->erreurs[] = 'La <b>description</b> est obligatoire';
        }
    }

    public function setLocalisation(string $localisation)
    {
        if (!empty($localisation)) {
            $this->localisation = $localisation;
        } else {
            $this->erreurs[] = 'La <b>localisation</b> est obligatoire';
        }
    }

    public function setContrat(string $contrat)
    {
        if (!empty($contrat)) {
            $this->contrat = $contrat;
        } else {
            $this->erreurs[] = 'Le type de <b>contrat</b> est obligatoire';
        }
    }

    public function setDate_ajout(string $date_ajout)
    {
        if (!empty($date_ajout)) {
            $this->date_ajout = $date_ajout;
        } else {
            $this->erreurs[] = "La <b>date d'ajout</b> est obligatoire";
        }
    }

    public function setLogo_entreprise(string $logo_entreprise)
    {
        if (!empty($logo_entreprise)) {
            $this->logo_entreprise = $logo_entreprise;
        }
    }

    // =============== LES GETTERS ===============

    public function getId_entreprise()
    {
        return $this->id_entreprise;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getNom_entreprise()
    {
        return $this->nom_entreprise;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getLocalisation()
    {
        return $this->localisation;
    }

    public function getContrat()
    {
        return $this->contrat;
    }

    public function getDate_ajout()
    {
        return $this->date_ajout;
    }

    public function getLogo_entreprise()
    {
        return $this->logo_entreprise;
    }


    // =============== LES METHODES ===============

    // methodes qui recupere les erreurs
    public function getErreurs()
    {
        return $this->erreurs;
    }

    // Methode qui verifie s'il y a des erreurs ou non
    public function isAnnonceValid()
    {
        return empty($this->erreurs);
    }
}