<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 25/02/17
 * Time: 20:25
 */
class Manager{
    private $_bdd;

    public function __construct()
    {
        try
        {
            $this->_bdd = new PDO('mysql:host=localhost;dbname=trello;charset=utf8', 'trellapp', 'access', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getUser($pseudo)
    {
        $req = $this->_bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $req->execute(array($pseudo,));
        $donnees = $req->fetch();
        $req->closeCursor(); // Termine le traitement de la requête
        return $donnees;
    }

    public function createUser($pseudo, $nom, $prenom, $mail, $passwd)
    {
        $req = $this->_bdd->prepare('INSERT INTO users (pseudo, nom, prenom, mail, passwd) VALUES (?,?,?,?,?)');
        $req->execute(array($pseudo, $nom, $prenom, $mail, $passwd));
        $req->closeCursor(); // Termine le traitement de la requête
    }

    public function addTable($titre ,$user_id)
    {
        $req = $this->_bdd->prepare('INSERT INTO tableaux (titre, id_user) VALUES (?,?)');
        return $req->execute(array($titre, $user_id,));
    }

    public function getTable($user_id)
    {
        $req = $this->_bdd->prepare('SELECT titre, id_table FROM tableaux WHERE id_user = ?');
        $req->execute(array($user_id,));
        $listes = array();
        while ($donnees = $req->fetch()) {
            $listes[] = new Tableau($donnees[0], $donnees[1], $user_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $listes;
    }

    public function getTableTitle($table_id)
    {
        $req = $this->_bdd->prepare('SELECT titre FROM tableaux WHERE id_table = ?');
        $req->execute(array($table_id,));
        $donnees = $req->fetch();
        $req->closeCursor(); // Termine le traitement de la requête
        return $donnees[0];
    }

    public function removeTable($table_id)
    {
        $req = $this->_bdd->prepare('DELETE FROM commentaires WHERE from_card IN (SELECT id_carte FROM cartes WHERE from_list IN (SELECT id_list FROM listes WHERE from_table=?))');
        $req->execute(array($table_id,));
        $req = $this->_bdd->prepare('DELETE FROM cartes WHERE from_list IN (SELECT id_list FROM listes WHERE from_table=?)');
        $req->execute(array($table_id,));
        $req = $this->_bdd->prepare('DELETE FROM listes WHERE from_table=?');
        $req->execute(array($table_id,));
        $req = $this->_bdd->prepare('DELETE FROM tableaux WHERE id_table=?');
        $req->execute(array($table_id,));
    }

    public function addList($titre ,$table_id)
    {
        $req = $this->_bdd->prepare('INSERT INTO listes (titre, from_table) VALUES (?,?)');
        return $req->execute(array($titre, $table_id,));
    }

    public function getList($table_id)
    {
        $req = $this->_bdd->prepare('SELECT titre, id_list FROM listes WHERE from_table = ?');
        $req->execute(array($table_id,));
        $listes = array();
        while ($donnees = $req->fetch()) {
            $listes[] = new Liste($donnees[0], $donnees[1], $table_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $listes;
    }

    public function removeList($list_id)
    {
        $req = $this->_bdd->prepare('DELETE FROM commentaires WHERE from_card IN (SELECT id_carte FROM cartes WHERE from_list=?)');
        $req->execute(array($list_id,));
        $req = $this->_bdd->prepare('DELETE FROM cartes WHERE from_list=?');
        $req->execute(array($list_id,));
        $req = $this->_bdd->prepare('DELETE FROM listes WHERE id_list=?');
        $req->execute(array($list_id,));

    }

    public function addCard($contenu, $list_id)
    {
        $req = $this->_bdd->prepare('INSERT INTO cartes (contenu, from_list) VALUES (?,?)');
        return $req->execute(array($contenu, $list_id,));
    }

    public function getCard($list_id)
    {
        $req = $this->_bdd->prepare('SELECT id_carte, contenu FROM cartes WHERE from_list = ?');
        $req->execute(array($list_id,));
        $cartes = array();
        while ($donnees = $req->fetch()) {
            $cartes[] = new Carte($donnees[0], $donnees[1], $list_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $cartes;
    }

    public function moveCard($list_id, $card_id)
    {
        $req = $this->_bdd->prepare('UPDATE cartes SET from_list = ? WHERE id_carte = ?');
        $req->execute(array($list_id, $card_id));
    }

    public function removeCard($card_id){
        $req = $this->_bdd->prepare('DELETE FROM commentaires WHERE from_card=?');
        $req->execute(array($card_id,));
        $req = $this->_bdd->prepare('DELETE FROM cartes WHERE id_carte=?');
        $req->execute(array($card_id,));

    }

    public function addComment($contenu, $card_id)
    {
        $req = $this->_bdd->prepare('INSERT INTO commentaires (contenu, from_card) VALUES (?,?)');
        $req->execute(array($contenu, $card_id,));
    }

    public function getComment($card_id)
    {
        $req = $this->_bdd->prepare('SELECT id_comment, contenu FROM commentaires WHERE from_card = ?');
        $req->execute(array($card_id,));
        $commentaires = array();
        while ($donnees = $req->fetch()) {
            $commentaires[] = new Commentaire($donnees[0], $donnees[1], $card_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $commentaires;
    }

    public function removeComment($com_id)
    {
        $req = $this->_bdd->prepare('DELETE FROM commentaires WHERE id_comment=?');
        $req->execute(array($com_id,));

    }
}