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

    public function __construct($pseudo, $passwd, $id, $nom, $prenom, $mail)
    {
        $this->_nom = $nom;
        $this->_prenom = $prenom;
        $this->_mail = $mail;
        $this->passwd = $passwd;
        $this->_pseudo = $pseudo;
        $this->_user_id = $id;
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
}