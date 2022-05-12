<?php

class EntreprisesManager
{
    // proprietes
    private $dbPDO;

    // constructeur
    public function __construct(PDO $dbPDO)
    {
        $this->dbPDO = $dbPDO;
    }

    // fonction qui va insérer un utilisateur dans la base de données
    public function inserer(Entreprise $entreprise)
    {
        $requete = $this->dbPDO->prepare('INSERT INTO entreprises (nom, email, mdp, tel, ville, secteur_activite, presentation, logo) VALUES (:nom, :email, :mdp, :tel, :ville, :secteur_activite, :presentation, :logo)');

        $requete->bindValue(':nom', $entreprise->getNom());
        $requete->bindValue(':email', $entreprise->getEmail());
        $requete->bindValue(':mdp', $entreprise->getMdp());
        $requete->bindValue(':tel', $entreprise->getTel());
        $requete->bindValue(':ville', $entreprise->getVille());
        $requete->bindValue(':secteur_activite', $entreprise->getSecteur_activite());
        $requete->bindValue(':presentation', $entreprise->getPresentation());
        $requete->bindValue(':logo', $entreprise->getLogo());

        $requete->execute();
    }

    public function afficherEntreprise(string $email)
    {
        $requete = $this->dbPDO->prepare('SELECT * FROM entreprises WHERE email = :email');
        $requete->bindValue(':email', $email);
        $requete->execute();

        $data = $requete->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function update_entreprise($id_entreprise,array $donnees)
    {

        // $requete = $this->dbPDO->query("SELECT * FROM entreprises WHERE id_entreprise = $id_entreprise");
        // $entreprise = $requete->fetch(PDO::FETCH_ASSOC);
        // faire un update du dit utilisateur
        $requete2= $this->dbPDO->prepare("UPDATE entreprises SET nom = :nom, email = :email, tel = :tel, ville = :ville, secteur_activite = :secteur_activite, presentation = :presentation  WHERE id_entreprise = $id_entreprise");
        
        $requete2->bindValue(':nom', $donnees['nom']);
        $requete2->bindValue(':email',$donnees['email'] );
        $requete2->bindValue(':tel', $donnees['tel']);
        $requete2->bindValue(':ville',$donnees['ville'] );
        $requete2->bindValue(':secteur_activite',$donnees['secteur_activite'] );
        $requete2->bindValue(':presentation',$donnees['presentation'] );

        $requete2->execute();

    }

        //methode delete_entreprise permet de supprimer le compte de l'entreprise
    public function delete_entreprise($id_entreprise)
    {
        if (isset($id_entreprise) && !empty($id_entreprise)) {
             $this->dbPDO->query("DELETE FROM entreprises WHERE id_entreprise = $id_entreprise");
        }
    }

}

