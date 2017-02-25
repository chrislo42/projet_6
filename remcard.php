<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 14/02/17
 * Time: 16:25
 */
if (isset( $_GET['cardid'] )) {
    $manage->removeCard($_GET['cardid']);
}

header("Location: main.php?page=tableau.php");