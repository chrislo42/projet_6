<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 13/02/17
 * Time: 12:54
 */
class Carte {
    private $_id_carte;
    private $_contenu;
    private $_from_list;

    public function __construct($id_carte, $contenu, $from_list)
    {
        $this->_contenu = $contenu;
        $this->_id_carte = $id_carte;
        $this->_from_list = $from_list;
    }

    public function getContenu()
    {
        return $this->_contenu;
    }

    public function getId()
    {
        return $this->_id_carte;
    }
}