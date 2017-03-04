<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 03/03/17
 * Time: 19:23
 */
class Tableau
{
    private $_titre;
    private $_user_id;
    private $_table_id;

    public function __construct($titre, $id, $user_id)
    {
        $this->_titre = $titre;
        $this->_table_id = $id;
        $this->_user_id = $user_id;
    }

    public function getTitre()
    {
        return $this->_titre;
    }

    public function getId()
    {
        return $this->_table_id;
    }
}