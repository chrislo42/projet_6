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
}