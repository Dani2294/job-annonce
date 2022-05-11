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
    public function update_utilisateur($id_utilisateur,array $donnees)
    {
        // au debut recuperation l'utilisateur de l'id correspondant 
        $requete = $this->dbPDO->query("SELECT * FROM utilisateurs WHERE id_utilisateur = $id_utilisateur");
        $user = $requete->fetch(PDO::FETCH_ASSOC);
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
        
    public function afficherUtilisateur(string $email)
    {
        $requete = $this->dbPDO->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $requete->bindValue(':email', $email);
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

    public function alertMessage($type, $message){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }
}