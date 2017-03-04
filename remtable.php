<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 03/03/17
 * Time: 19:18
 */
if (isset( $_GET['tableid'] )) {
    $manage->removeTable($_GET['tableid']);
}

header("Location: main.php?page=accueil.php");