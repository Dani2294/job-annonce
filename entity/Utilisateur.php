<?php

// Cette classe utilisateur sert à définir un utilisateurs 
// lors de son inscription
class Utilisateur
{
    // proprietes

    // Tableau d'erreurs qui vas nous servir pour récupérer les erreurs
    private $erreurs = [];

    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $tel;
    private $civilite;
    private $ville;

     // creation du constructeur
    public function __construct(array $donnees)
    {
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }

    // methode hydrater qui va hydrater les données de l utilisateur dans les proprietes grace au setteur
    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $valeur = htmlspecialchars($valeur);
            $valeur = addslashes($valeur);

            $methodeSetters = 'set' . ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    // =============== LES SETTERS ===============
    public function setNom(string $nom)
    {
        if (!empty($nom)) {
            if(strlen($nom) < 2 || strlen($nom) > 52){
                $this->erreurs[] = 'Le <b>nom</b> doit contenir entre 2 et 52 caractères';
            } else {
                $this->nom = $nom;
            }
        } else {
            $this->erreurs[] = 'Le <b>nom</b> est obligatoire';
        }
    }

    public function setPrenom(string $prenom)
    {
        if (!empty($prenom)) {
            if(strlen($prenom) < 2 || strlen($prenom) > 52){
                $this->erreurs[] = 'Le <b>prenom</b> doit contenir entre 2 et 52 caractères';
            } else {
                $this->prenom = $prenom;
            }
        } else {
            $this->erreurs[] = 'Le <b>prenom</b> est obligatoire';
        }
    }

    public function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            $this->erreurs[] = "<b>L'email</b> n'est pas valide";
        }
    }

    public function setMdp(string $mdp)
    {
        if(!empty($mdp)){
            if(strlen($mdp) <= 5){
                $this->erreurs[] = 'Le <b>mot de passe</b> doit contenir au moins 6 caractères';
            } else {
                // On crypte le mot de passe avant de le stocker dans la bdd
                $cryptedMpd = password_hash($mdp, PASSWORD_DEFAULT);
                $this->mdp = $cryptedMpd;
            }
        } else {
            $this->erreurs[] = 'Le <b>mot de passe</b> est obligatoire';
        }
    }

    public function setTel(string $tel)
    {
        if (!empty($tel)) {
            $this->tel = $tel;
        } else {
            $this->erreurs[] = 'Le <b>numéro de téléphone</b> est obligatoire';
        }
    }

    public function setCivilite(string $civilite)
    {
        if (!empty($civilite)) {
            $this->civilite = $civilite;
        } else {
            $this->erreurs[] = 'La <b>civilité</b> est obligatoire';
        }
    }

    public function setVille(string $ville)
    {
        if (!empty($ville)) {
            $this->ville = $ville;
        } else {
            $this->erreurs[] = 'La <b>ville</b> est obligatoire';
        }
    }

    // =============== LES GETTERS ===============
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


    // =============== LES METHODES ===============
    // methode qui recupere les erreurs
    public function getErreurs()
    {
        return $this->erreurs;
    }

    // methode qui verifie si l utilisateur est valide
    public function isUserValide()
    {
        // verification: si le tableau d'erreur est vide
        return empty($this->erreurs);
    }
}