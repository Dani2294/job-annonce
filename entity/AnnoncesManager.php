<?php

class AnnoncesManager
{
    // proprietes   
    private $dbPDO;
    public $id;

    // constructeur
    public function __construct(PDO $dbPDO)
    {
        $this->dbPDO = $dbPDO;
    }

     //requete d'insertion d'une annonce*
    public function inserer(Annonce $annonce)
    {
        $requete = $this->dbPDO->prepare('INSERT INTO annonces (id_entreprise, titre, description, localisation, contrat, date_ajout) VALUES (:id_entreprise, :titre, :description, :localisation, :contrat, :date_ajout)');   
        
        $requete->bindValue(':id_entreprise', $annonce->getId_entreprise());
        $requete->bindValue(':titre', $annonce->getTitre());
        $requete->bindValue(':description', $annonce->getDescription());
        $requete->bindValue(':localisation', $annonce->getLocalisation());
        $requete->bindValue(':contrat', $annonce->getContrat());
        $requete->bindValue(':date_ajout', $annonce->getDate_ajout());

        $requete->execute();
    }

    
    //requete toutes les annonces
    public function recupAllAnnonces()
    {
        $requete = $this->dbPDO->query("SELECT * FROM annonces");
        $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $donnees;
    }

    //requete recuperer une seule annonce
    
    //requete des annonces d'une entreprise spécifique
    public function recupEntrepriseAnnonces($id_entreprise)
    {
        $requete = $this->dbPDO->prepare("SELECT * FROM annonces WHERE id_entreprise = :id_entreprise");
        $requete->bindValue(':id_entreprise', $id_entreprise);
        $requete->execute();

        $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $donnees;
    }
    
    //requete de modification d'une annonce

    //requete de suppression d'une annonce
    public function delete_annonce()
    {
        if (isset($this->id) && !empty($this->id)) {
             $this->dbPDO->query("DELETE FROM annonces WHERE id_annonce = $this->id");
        }
    }

    /*
     public function verifTitre(string $titre)
     {
    
      $requete = $this->dbPDO->prepare("SELECT id_annonce FROM annonces WHERE titre = :titre");
      $requete->bindValue(':titre',$titre);
      $requete->execute();
      //$tableau = $requete->fetch(PDO::FETCH_ASSOC);
    //$this->id = $tableau['id_annonce'];
      return $requete;

     }
     */
     

    
     

    public function alertMessage($type, $message){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }

   

}