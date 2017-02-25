<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 08/02/17
 * Time: 10:53
 */

$pseudo = "";
$passwd = "";
$erreur = "";
$code = "0";

if (isset($_POST['pseudo'])){
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $passwd = htmlspecialchars($_POST['passwd']);
    $donnees = $manage->getUser($pseudo);
    if ($donnees) {
        if ($donnees['passwd'] == $passwd) {
            $user = new User($pseudo, $passwd, $donnees['id'], $donnees['nom'], $donnees['prenom'], $donnees['mail']);
            $_SESSION['page'] = "tableau.php";
            $_SESSION ['user'] = $user;
            header("Location: main.php?page=tableau.php");
        }
        else {
            $erreur = "Le mot de passe n'est pas correct !";
            $code = "3";
        }
    }
    else {
        $erreur = "Le pseudo n'est pas correct !";
        $code = "1";

    }
}

?>
<div class="row">
    <div class="col-xs-2 col-xs-offset-1">
        <form method="post" action="main.php" name="login">
            <p>
                <label for="val1"> Pseudo : </label><input class="entree" onclick="$('#val1').css({background:'#f1f1f1'});" name="pseudo" id="val1" type="text" value="<?php echo $pseudo;?>" required/><br />
                <br />
                <label for="val3"> Mot de passe : </label><input class="entree" onclick="$('#val3').css({background:'#f1f1f1'});" name="passwd" id="val3" type="password" value="<?php echo $passwd;?>" required/><br />
                <br />
            </p>
            <p>
                <button type="submit" class="btn btn-primary btn-sm">Entrer</button><br />
                <br />
            </p>
        </form>
        <a href="main.php?page=register.php">-> S'incrire <-</a>
    </div>
    <div class="col-xs-4 col-xs-offset-1">
        <?php
            if (isset($_POST['pseudo'])){
                if ($erreur == ""){
                    echo "Connexion réussie";
                }else{
                    echo "Pas de connexion : vérifier des données fournies !<br />";
                    echo $erreur;
                    ?>
                    <script type="text/javascript">
                        $('#val<?php echo $code;?>').css({background:'red'});
                    </script>
                    <?php
                }
            }
        ?>
    </div>
</div>