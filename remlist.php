<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 14/02/17
 * Time: 14:45
 */
if (isset( $_GET['listid'] )) {
    $req = $bdd->prepare('DELETE FROM listes WHERE id_list=?');
    $req->execute(array($_GET['listid'],));
    $req = $bdd->prepare('DELETE FROM commentaires WHERE from_card IN (SELECT id_carte FROM cartes WHERE from_list=?)');
    $req->execute(array($_GET['listid'],));
    $req = $bdd->prepare('DELETE FROM cartes WHERE from_list=?');
    $req->execute(array($_GET['listid'],));
}

header("Location: main.php?page=tableau.php");