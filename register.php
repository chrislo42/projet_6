<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 16/02/17
 * Time: 09:08
 */
$erreur = "";
$code = "0";
$pseudo = "";
$nom = "";
$prenom = "";
$mail = "";
$passwd = "";


if (isset($_POST['pseudo'])){
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $mail = htmlspecialchars($_POST['mail']);
    $passwd = htmlspecialchars($_POST['passwd']);
    if ($passwd == $_POST['conf_passwd']){
        $donnees = $manage->getUser($pseudo);
        if ($donnees) {
            $erreur = "Le pseudo existe déjà !";
            $code = "1";
        }
        else {
            $manage->createUser($pseudo, $nom, $prenom, $mail, $passwd);
            $donnees = $manage->getUser($pseudo);
            $user = new User($pseudo, $passwd, $donnees['id'], $nom, $prenom, $mail);
            $_SESSION['page'] = "tableau.php";
            $_SESSION ['user'] = $user;
            header("Location: main.php?page=tableau.php");
        }
    }
    else {
        $erreur = "Les deux mots de passe ne sont pas égaux !";
        $code = "6";
    }
}

?>
<div class="row">
    <form method="post" action="main.php" name="register">
        <div class="col-xs-2 col-xs-offset-1">
            <p>
                <label for="val1"> Pseudo :</label><input class="entree" name="pseudo" id="val1" type="text" onclick="$('#val1').css({background:'#f1f1f1'});" value="<?php echo $pseudo;?>" required/><br />
                <br />
                <label for="val2"> Nom :</label><input class="entree" name="nom" id="val2" type="text" value="<?php echo $nom;?>" required/><br />
                <br />
                <label for="val3"> Prénom :</label><input class="entree" name="prenom" id="val3" type="text" value="<?php echo $prenom;?>" required/><br />
                <br />
            </p>
            <p>
                <button type="submit" class="btn btn-primary btn-sm">Inscription</button>
            </p>
        </div>
        <div class="col-xs-2 col-xs-offset-1">
            <p>
                <label for="val4"> Mail : </label><input class="entree" name="mail" id="val4" type="text" value="<?php echo $mail;?>" required/><br />
                <br />
                <label for="val5"> Mot de passe : </label><input class="entree" name="passwd" id="val5" type="password" value="<?php echo $passwd;?>" required/><br />
                <br />
                <label for="val6"> Confirmer mot de passe</label><input class="entree" onclick="$('#val6').css({background:'#f1f1f1'});" name="conf_passwd" id="val6" type="password" value="" required/><br />
                <br />
            </p>
            <p>
                <a href="main.php?page=logout.php"><button class="btn btn-primary btn-sm">Abandonner</button></a>
            </p>
        </div>
    </form>
    <div class="col-xs-4 col-xs-offset-1">
        <?php
        if (isset($_POST['pseudo'])){
            if ($erreur == ""){
                echo "Inscription réussie";
            }else{
                echo "Inscription abandonnée : vérifier des données fournies<br />";
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