<?php

class UtilisateursManager
{
    // proprietes
    private $dbPDO;

    // constructeur
    public function __construct(PDO $dbPDO)
    {
        $this->dbPDO = $dbPDO;
    }

    // fonction qui va insérer un utilisateur dans la base de données
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

    public function afficherUtilisateur(string $email)
    {
        $requete = $this->dbPDO->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $requete->bindValue(':email', $email);
        $requete->execute();

        $data = $requete->fetch(PDO::FETCH_ASSOC);

        return $data;
    }


    public function alertMessage($type, $message){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }
}