<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 15/02/17
 * Time: 15:49
 */

if (isset( $_GET['comid'] )) {
    $manage->removeComment($_GET['comid']);
}

header("Location: main.php?page=tableau.php");