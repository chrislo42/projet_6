<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 14/02/17
 * Time: 14:45
 */
if (isset( $_GET['listid'] )) {
    $manage->removeList($_GET['listid']);
}

header("Location: main.php?page=tableau.php");