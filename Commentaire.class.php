<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 13/02/17
 * Time: 13:11
 */
class Commentaire
{
    private $_id_comment;
    private $_contenu;
    private $_from_card;

    public function __construct($id_comment, $contenu, $from_card)
    {
        $this->_contenu = $contenu;
        $this->_id_comment = $id_comment;
        $this->_from_card = $from_card;
    }

    public function getContenu()
    {
        return $this->_contenu;
    }

    public function getId()
    {
        return $this->_id_comment;
    }
}
