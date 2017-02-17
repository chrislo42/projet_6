<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 08/02/17
 * Time: 10:30
 */
function __autoload($class_name) {
    include $class_name . '.class.php';
}
session_start();


try
{
    $bdd = new PDO('mysql:host=localhost;dbname=trello;charset=utf8', 'trellapp', 'access', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


if (!isset($_SESSION['page'])) { $_SESSION['page'] = "login.php"; }
if (isset( $_GET['page'] )) { $_SESSION['page'] = $_GET['page']; }
$titre_page = substr ( $_SESSION['page'], 0, strpos ( $_SESSION['page'], "." ) ); // tri du nom de la page
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Treloo by DTA</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="style.css">
        <script src = "https://code.jquery.com/jquery-1.11.2.min.js"> </script>
        <script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"> </script>
	</head>
	<body>
        <div id="main_body">
        <div id="fade" class="black_overlay"></div>
        <div class="page-header">
            <?php
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    ?>
                    <a href="main.php?page=logout.php" class="top-menu"><span class="glyphicon glyphicon-log-out"></span></a>
                    <p class="top-menu">
                        <small>Hello <?php echo($user->bonjour()); ?> -</small>
                    </p>
                    <?php
                }
            ?>
            <img src="images/DTA.jpg" alt="Logo DTA small"/>
            <h1>Treloo by DTA - <?php echo ($titre_page);?></h1>
        </div>
        <div class="main">
            <div class="container-fluid">
                <?php
                include ($_SESSION['page']);
                ?>
            </div>
        </div>
        <footer>
            <p>© 2017 - Design Tech Académie</p>
        </footer>
        </div>
    </body>
</html>