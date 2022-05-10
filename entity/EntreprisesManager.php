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


    public function alertMessage($type, $message){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }
}