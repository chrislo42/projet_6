<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 14/02/17
 * Time: 16:25
 */
if (isset( $_GET['cardid'] )) {
    $req = $bdd->prepare('DELETE FROM commentaires WHERE from_card=?');
    $req->execute(array($_GET['cardid'],));
    $req = $bdd->prepare('DELETE FROM cartes WHERE id_carte=?');
    $req->execute(array($_GET['cardid'],));
}

header("Location: main.php?page=tableau.php");