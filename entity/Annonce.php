<?php

class Annonce
{
   // proprietes
   private $id_entreprise; 
   private $titre;
   private $description;
   private $localisation;
   private $contrat;
   private $date_ajout;

   //constructeur

   public function __construct(array $donnees){
    if (!empty($donnees)) {
        $this->hydrater($donnees);
    }
}
// fonction hydrater qui va hydrater les données de l utilisateur 
// dans les proprietes grace au setteur

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
    }
}

public function setDescription(string $description)
{
    if (!empty($description)) {
        $this->description = $description;
    }
}

public function setLocalisation(string $localisation)
{
    if (!empty($localisation)) {
        $this->localisation = $localisation;
    }
}

public function setContrat(string $contrat)
{
    if (!empty($contrat)) {
        $this->contrat = $contrat;
    }
}

public function setDate_ajout(string $date_ajout)
{
    if (!empty($date_ajout)) {
        $this->date_ajout = $date_ajout;
    }
}

// getters

public function getId_entreprise()
{
    return $this->id_entreprise;
}

public function getTitre()
{
    return $this->titre;
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





}