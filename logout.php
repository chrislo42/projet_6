<?php
    $_SESSION = array();
    session_destroy();
    header("Location: main.php?page=login.php");