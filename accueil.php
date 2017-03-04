<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 03/03/17
 * Time: 18:45
 */
$user = $_SESSION['user'];
$_SESSION['tableid'] = "";

// Nouveau tableau
if (isset($_POST['titre'])){
    $titre = htmlspecialchars($_POST['titre']);
    $manage->addTable($titre, $user->getId());
}
// chargement des tableaux du user
$tableaux = $manage->getTable($user->getId());

echo ("<div class=\"row\">");
foreach ($tableaux as $index => $table){ ?>
    <!-- affichage du tableau -->
    <div class="col-xs-3 color">
        <!-- croix de suppression -->
        <a class="pull-right" href="javascript:void(0)" onclick="document.getElementById('light_tab<?php echo $table->getId(); ?>').style.display='block';document.getElementById('fade').style.display='block'">
            <span class="glyphicon glyphicon-remove"></span></a>
            <div id="light_tab<?php echo $table->getId(); ?>" class="white_content_comment">
                <!-- croix de fermeture -->
                <a class="right" href="javascript:void(0)" onclick="document.getElementById('fade').style.display='none'; document.getElementById('light_tab<?php echo $table->getId(); ?>').style.display='none'">
                    <span class="glyphicon glyphicon-remove"></span></a>
                <h4>Etes vous sûr de vouloir supprimer ce tableau !</h4>
                <a href="main.php?page=remtable.php&tableid=<?php echo $table->getId(); ?>" ><button class=\"btn btn-primary btn-xs\">Supprimer !</button></a>
            </div>
        <!-- branchement sur tableau -->
        <a href="main.php?page=tableau.php&tableid=<?php echo $table->getId(); ?>" >
            <h2><?php echo $table->getTitre(); ?></h2></a>
    </div>
        <?php
    }
    ?>
    <div class="col-xs-3 color4">
        <!-- formulaire caché d'ajout de liste -->
        <div id="dark_li" class="white_content">
            <form method="post" action="main.php" name="liste">
                <input name="titre" class="form-control" type="text" placeholder="Créer un tableau..." required/>
                <input class="btn btn-default btn-success btn-xs" type="submit" value="Entrer" />
                <!-- abandon du formulaire -->
                <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_li').style.display='none'; document.getElementById('light_li').style.display='block'">
                    <span class="glyphicon glyphicon-remove"></span></a>
            </form>
        </div>
        <!-- bouton de mise à jour du formulaire -->
        <div id="light_li">
            <a href="javascript:void(0)" onclick="document.getElementById('dark_li').style.display='block'; document.getElementById('light_li').style.display='none'">Créer un tableau...</a>
        </div>
    </div>
</div>