<?php

// Cette classe permet de gérer les reqêtes SQL pour les utilisateurs
class UtilisateursManager
{
    // proprietes
    private $dbPDO;

    // constructeur
    public function __construct(PDO $dbPDO)
    {
        $this->dbPDO = $dbPDO;
    }

    // methode qui va insérer un utilisateur dans la base de données
    public function inserer(Utilisateur $utilisateur)
    {
        $requete = $this->dbPDO->prepare('INSERT INTO utilisateurs (nom, prenom, email, mdp, tel, civilite, ville) VALUES (:nom, :prenom, :email, :mdp, :tel, :civilite, :ville)');

        $requete->bindValue(':nom', $utilisateur->getNom());
        $requete->bindValue(':prenom', $utilisateur->getPrenom());
        $requete->bindValue(':email', $utilisateur->getEmail());
        $requete->bindValue(':mdp', $utilisateur->getMdp());
        $requete->bindValue(':tel', $utilisateur->getTel());
        $requete->bindValue(':civilite', $utilisateur->getCivilite());
        $requete->bindValue(':ville', $utilisateur->getVille());

        $requete->execute();
    }

    // methode qui va mettre à jour les informations d'un utilisateur
    public function update_utilisateur($id_utilisateur,array $donnees)
    {
        // faire un update du dit utilisateur
        $requete2= $this->dbPDO->prepare("UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, tel = :tel, civilite = :civilite, ville = :ville  WHERE id_utilisateur = $id_utilisateur");
        
        $requete2->bindValue(':nom', $donnees['nom']);
        $requete2->bindValue(':prenom', $donnees['prenom']);
        $requete2->bindValue(':email',$donnees['email'] );
        $requete2->bindValue(':civilite', $donnees['civilite']);
        $requete2->bindValue(':ville',$donnees['ville'] );
        $requete2->bindValue(':tel', $donnees['tel']);
        $requete2->execute();    

    }
    
    // methode qui va récupérer un utilisateur de la base de données
    public function afficherUtilisateur(string $email, string $nom)
    {
        $requete = $this->dbPDO->prepare('SELECT * FROM utilisateurs WHERE email = :email AND nom = :nom');
        $requete->bindValue(':email', $email);
        $requete->bindValue(':nom', $nom);
        $requete->execute();

        $data = $requete->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    //methode delete_utilisateur permet de supprimer le compte de l'utilisateur
    public function delete_utilisateur($id_utilisateur)
    {
        if (isset($id_utilisateur) && !empty($id_utilisateur)) {
            $this->dbPDO->query("DELETE FROM utilisateurs WHERE id_utilisateur = $id_utilisateur");
        }
    }
}