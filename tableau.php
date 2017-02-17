<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 08/02/17
 * Time: 13:07
 */
$user = $_SESSION['user'];

// Nouvelle liste
if (isset($_POST['titre'])){
    $user->addList($_POST['titre'], $bdd);
}

// Nouvelle carte
if (isset($_POST['carte'])){
    $req = $bdd->prepare('INSERT INTO cartes (contenu, from_list) VALUES (?,?)');
    $req->execute(array($_POST['contenu'], $_POST['lid'],));
}

// Nouveau commentaire
if (isset($_POST['commentaire'])){
    $req = $bdd->prepare('INSERT INTO commentaires (contenu, from_card) VALUES (?,?)');
    $req->execute(array($_POST['contenu'], $_POST['cid'],));
}

// Deplacement de carte
if (isset($_POST['deplacer'])){
    $req = $bdd->prepare('UPDATE cartes SET from_list = ? WHERE id_carte = ?');
    $req->execute(array($_POST['choix'], $_POST['cid'],));
}

// chargement des listes du user
$listes = $user->getList($bdd);

echo ("<div class=\"row\">");
    foreach ($listes as $index => $liste){ ?>
        <!-- affichage de la liste -->
        <div class="col-xs-2 color1">
            <!-- croix de suppression -->
            <a class="pull-right" href="main.php?page=remlist.php&listid=<?php echo $liste->getId(); ?>" >X</a>
            <h2><?php echo $liste->getTitre(); ?></h2>
            <?php
            // chargement des cartes de la liste
            $cartes = $liste->getCard($bdd);
            foreach ($cartes as $carte){
                ?>
                <!-- affichage des cartes -->
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 color2">
                        <!-- croix de suppression -->
                        <a class="pull-right" href="main.php?page=remcard.php&cardid=<?php echo $carte->getId(); ?>" >X</a>
                        <p>Carte : <a href="javascript:void(0)" onclick="document.getElementById('light_car<?php echo $carte->getId(); ?>').style.display='block';document.getElementById('fade').style.display='block'"> [ -> ]</a></p>
                        <div id="light_car<?php echo $carte->getId(); ?>" class="white_content_comment">
                            <a class="right" href="javascript:void(0)" onclick="document.getElementById('fade').style.display='none'; document.getElementById('light_car<?php echo $carte->getId(); ?>').style.display='none'">X</a>
                            <h4>Déplacer la carte : <?php echo $carte->getContenu(); ?></h4>
                            <form method="post" action="main.php" name="comment">
                                <select name="choix">
                                    <?php
                                    foreach ($listes as $choix){
                                        //echo ($choix->getTitre());
                                        echo ("<option value=\"".$choix->getId()."\">".$choix->getTitre()."</option>");
                                    }
                                    ?>
                                </select>
                                <input name="cid" class="btn btn-default btn-success btn-xs" type="hidden" value="<?php echo $carte->getId(); ?>"/>
                                <input name="deplacer" class="btn btn-default btn-success btn-xs pull-right" type="submit" value="Déplacer"/>
                            </form>
                        </div>
                        <a href="javascript:void(0)" onclick="document.getElementById('light_com<?php echo $carte->getId(); ?>').style.display='block';document.getElementById('fade').style.display='block'"><p><?php echo $carte->getContenu(); ?></p>
                        <?php
                        //chargement des commentaires de la carte
                        $commentaires = $carte->getComment($bdd);
                        if (count($commentaires)) {
                            // affichage du logo commentaire avec le nombre de commentaires, déclanche la mise à jour des commentaires
                            echo("<button class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-comment\"></span> " . count($commentaires) . " commentaire(s)</button>");
                        }
                        ?>
                        </a>
                        <!-- fenêtre cachée des commentaires -->
                        <div id="light_com<?php echo $carte->getId(); ?>" class="white_content_comment">
                            <!-- croix de fermeture -->
                            <a class="right" href="javascript:void(0)" onclick="document.getElementById('fade').style.display='none'; document.getElementById('light_com<?php echo $carte->getId(); ?>').style.display='none'">X</a>
                            <h4>Commentaire(s) de la carte: <?php echo $carte->getContenu(); ?> appartenant à la liste : <?php echo $liste->getTitre(); ?></h4>
                            <hr>
                            <?php
                            foreach ($commentaires as $commentaire){
                                // croix de suppression
                                echo ("<a class=\"pull-right\" href=\"main.php?page=remcom.php&comid=".$commentaire->getId()."\" >X</a>");
                                echo ("<p>".$commentaire->getContenu()."</p>");
                                echo ("<hr>");
                            }
                            ?>
                            <!-- formulaire caché d'ajout de commentaire -->
                            <div id="dark_co<?php echo $carte->getId(); ?>" class="white_content">
                                <form method="post" action="main.php" name="comment">
                                    <input name="contenu" class="form-control" type="text" placeholder="Ajouter un commentaire..." required/>
                                    <input name="commentaire" class="btn btn-default btn-success btn-xs" type="submit" value="Entrer"/>
                                    <!-- entrée pour récupérer l'id de liste -->
                                    <input name="cid" class="btn btn-default btn-success btn-xs" type="hidden" value="<?php echo $carte->getId(); ?>"/>
                                    <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_co<?php echo $carte->getId(); ?>').style.display='none'; document.getElementById('light_co<?php echo $carte->getId(); ?>').style.display='block'">X</a>
                                </form>
                            </div>
                            <!-- bouton de mise à jour du formulaire -->
                            <div id="light_co<?php echo $carte->getId(); ?>">
                                <a href="javascript:void(0)" onclick="document.getElementById('dark_co<?php echo $carte->getId(); ?>').style.display='block'; document.getElementById('light_co<?php echo $carte->getId(); ?>').style.display='none'">Ajouter un commentaire...</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <!-- formulaire caché d'ajout de carte -->
            <div id="dark_ca<?php echo $index; ?>" class="white_content">
                <form method="post" action="main.php" name="carte">
                    <input name="contenu" class="form-control" type="text" placeholder="Ajouter une carte..." required/>
                    <input name="carte" class="btn btn-default btn-success btn-xs" type="submit" value="Entrer"/>
                    <!-- entrée pour récupérer l'id de liste -->
                    <input name="lid" class="btn btn-default btn-success btn-xs" type="hidden" value="<?php echo $liste->getId(); ?>"/>
                    <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_ca<?php echo $index; ?>').style.display='none'; document.getElementById('light_ca<?php echo $index; ?>').style.display='block'">X</a>
                </form>
            </div>
            <!-- bouton de mise à jour du formulaire -->
            <div id="light_ca<?php echo $index; ?>">
                <a href="javascript:void(0)" onclick="document.getElementById('dark_ca<?php echo $index; ?>').style.display='block'; document.getElementById('light_ca<?php echo $index; ?>').style.display='none'">Ajouter une carte...</a>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="col-xs-2 color1">
        <!-- formulaire caché d'ajout de liste -->
        <div id="dark_li" class="white_content">
            <form method="post" action="main.php" name="liste">
                <input name="titre" class="form-control" type="text" placeholder="Ajouter une liste..." required/>
                <input class="btn btn-default btn-success btn-xs" type="submit" value="Entrer" />
                <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_li').style.display='none'; document.getElementById('light_li').style.display='block'">X</a>
            </form>
        </div>
        <!-- bouton de mise à jour du formulaire -->
        <div id="light_li">
            <a href="javascript:void(0)" onclick="document.getElementById('dark_li').style.display='block'; document.getElementById('light_li').style.display='none'">Ajouter une liste...</a>
        </div>
    </div>
</div>
