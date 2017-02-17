<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 08/02/17
 * Time: 10:53
 */

if (isset($_POST['pseudo'])){
    $pseudo = $_POST['pseudo'];
    $passwd = $_POST['passwd'];
    $user = new User($pseudo, $passwd, $bdd);
    if ($user->getNom()) {
        $_SESSION['page'] = "tableau.php";
        $_SESSION ['user'] = $user;
        header("Location: main.php?page=tableau.php");
    }
}
else{
    $pseudo = "";
    $passwd = "";
}

?>
<div class="row">
    <div class="col-xs-2 col-xs-offset-1">
        <form method="post" action="main.php" name="login">
            <p>
                <label for="val1"> Pseudo : </label><input class="entree" name="pseudo" id="val1" type="text" value="<?php echo $pseudo;?>" required/><br />
                <br />
                <label for="val3"> Mot de passe : </label><input class="entree" name="passwd" id="val3" type="password" value="<?php echo $passwd;?>" required/><br />
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
                if (isset($_SESSION['user'])){
                    echo "Connexion réussie";
                }else{
                    echo "Pas de connexion : vérifier des données fournies";
                }
            }
        ?>
    </div>
</div>