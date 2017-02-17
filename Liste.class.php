<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 13/02/17
 * Time: 11:31
 */
class Liste
{
    private $_titre;
    private $_user_id;
    private $_list_id;

    public function __construct($titre, $id, $user_id)
    {
        $this->_titre = $titre;
        $this->_list_id = $id;
        $this->_user_id = $user_id;
    }

    public function getTitre()
    {
        return $this->_titre;
    }

    public function getId()
    {
        return $this->_list_id;
    }

    public function getCard($bdd)
    {
        $req = $bdd->prepare('SELECT id_carte, contenu FROM cartes WHERE from_list = ?');
        $req->execute(array($this->_list_id,));
        $listes = array();
        while ($donnees = $req->fetch()) {
            $listes[] = new Carte($donnees[0], $donnees[1], $this->_user_id);
        }
        $req->closeCursor(); // Termine le traitement de la requête
        return $listes;

    }
}