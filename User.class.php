<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 08/02/17
 * Time: 10:22
 */
class User{

    private $_nom;
    private $_pseudo;
    private $_prenom;
    private $_mail;
    private $passwd;
    private $_user_id;

    public function __construct($pseudo, $passwd, $bdd, $nom="", $prenom="", $mail="")
    {
        $req = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $req->execute(array($pseudo,));
        $donnees = $req->fetch();
        $req->closeCursor(); // Termine le traitement de la requête
        if ($donnees) {
            if ($donnees['passwd'] == $passwd) {
                $this->_nom = $donnees['nom'];
                $this->_prenom = $donnees['prenom'];
                $this->_mail = $donnees['mail'];
                $this->passwd = $passwd;
                $this->_pseudo = $pseudo;
                $this->_user_id = $donnees['id'];
            }
        }
        else {
            $req = $bdd->prepare('INSERT INTO users (pseudo, nom, prenom, mail, passwd) VALUES (?,?,?,?,?)');
            $req->execute(array($pseudo, $nom, $prenom, $mail, $passwd));
            $req = $bdd->prepare('SELECT id FROM users WHERE pseudo = ?');
            $req->execute(array($pseudo,));
            $donnees = $req->fetch();
            $req->closeCursor(); // Termine le traitement de la requête
            $this->_nom = $nom;
            $this->_prenom = $prenom;
            $this->_mail = $mail;
            $this->passwd = $passwd;
            $this->_pseudo = $pseudo;
            $this->_user_id = $donnees['id'];
        }
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getPrenom()
    {
        return $this->_prenom;
    }

    public function bonjour()
    {
        return $this->_prenom." ".$this->_nom;
    }

    public function getId()
    {
        return $this->_user_id;
    }

    public function getList($bdd)
    {
        $req = $bdd->prepare('SELECT titre, id_list FROM listes WHERE id_user = ?');
        $req->execute(array($this->_user_id,));
        $listes = array();
        while ($donnees = $req->fetch()) {
            $listes[] = new Liste($donnees[0], $donnees[1], $this->_user_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $listes;
    }

    public function addList($titre, $bdd)
    {
        $req = $bdd->prepare('INSERT INTO listes (titre, id_user) VALUES (?,?)');
        return $req->execute(array($titre, $this->_user_id,));
    }
}