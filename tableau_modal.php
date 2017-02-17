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

    // chargement des listes du user
    $listes = $user->getList($bdd);

    echo ("<div class=\"row\">");
        foreach ($listes as $index => $liste){
            // affichage de la liste
            echo ("<div class=\"col-sm-2 color1\">");
            // croix de suppression
            echo ("<a class=\"pull-right\" href=\"main.php?page=remlist.php&listid=".$liste->getId()."\" >X</a>");
            echo ("<h2>".$liste->getTitre()."</h2>");
            // chargement des carte de la liste
            $cartes = $liste->getCard($bdd);
            foreach ($cartes as $carte){
                // affichage des cartes
                echo ("<div class=\"row\">");
                echo ("<div class=\"col-sm-10 col-sm-offset-1 color2\">");
                // croix de suppression
                echo ("<a class=\"pull-right\" href=\"main.php?page=remcard.php&cardid=".$carte->getId()."\" >X</a>");
                echo ("<p>Carte :</p>");
                echo ("<p>".$carte->getContenu()."</p>");
                //chargement des commentaires de la carte
                $commentaires = $carte->getComment($bdd);
                if (count($commentaires)){
                    // affichage du logo commentaire avec le nombre de commentaires
                    echo ("<button class=\"btn btn-primary btn-xs\" data-toggle='modal' data-target='#aff_com".$carte->getId()."'><span class=\"glyphicon glyphicon-comment\"></span> ".count($commentaires)." commentaire(s)</button>");
                    ?>
                    <!-- Fenêtre Modal -->
                    <div class="modal fade" id="aff_com<?php echo $carte->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $carte->getId(); ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel<?php echo $carte->getId(); ?>">Commentaire(s) :</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    foreach ($commentaires as $commentaire){
                                        // croix de suppression
                                        echo ("<a class=\"pull-right\" href=\"main.php?page=remlist.php&listid=".$liste->getId()."\" >X</a>");
                                        echo ("<p>".$commentaire->getContenu()."</p>");
                                        echo ("<hr>");
                                    }
                                    echo ("<a href='logout.php'>logout</a>")
                                    ?>
                                    <a href='logout.php'>logout</a>
                                </div>
                                <div class="modal-footer">
                                    <!-- formulaire caché d'ajout de commentaire -->
                                    <div id="dark_com" class="white_content">
                                        <form method="post" action="main.php" name="comment">
                                            <input name="contenu" class="form-control" type="text" placeholder="Ajouter une carte..." required/>
                                            <input name="carte" class="btn btn-default btn-success btn-xs" type="submit" value="Entrer"/>
                                            // entrée pour récupérer l'id de liste
                                            <input name="lid" class="btn btn-default btn-success btn-xs" type="hidden" value="<?php echo $liste->getId(); ?>"/>
                                            <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_com').style.display='none'; document.getElementById('light_com').style.display='block'">X</a>
                                        </form>
                                    </div>
                                    <!-- bouton de mise à jour du formulaire -->
                                    <div id="light_com">
                                        <a href="javascript:void(0)" onclick="document.getElementById('dark_com').style.display='block'; document.getElementById('light_com').style.display='none'">Ajouter un commentaire...</a>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <?php
                }
                echo ("</div>");
                echo ("</div>");
            }
            ?>
            <!-- formulaire caché d'ajout de carte -->
            <div id="dark_c<?php echo $index; ?>" class="white_content">
                <form method="post" action="main.php" name="carte">
                    <input name="contenu" class="form-control" type="text" placeholder="Ajouter une carte..." required/>
                    <input name="carte" class="btn btn-default btn-success btn-xs" type="submit" value="Entrer"/>
                    // entrée pour récupérer l'id de liste
                    <input name="lid" class="btn btn-default btn-success btn-xs" type="hidden" value="<?php echo $liste->getId(); ?>"/>
                    <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_c<?php echo $index; ?>').style.display='none'; document.getElementById('light_c<?php echo $index; ?>').style.display='block'">X</a>
                </form>
            </div>
            <!-- bouton de mise à jour du formulaire -->
            <div id="light_c<?php echo $index; ?>">
                <a href="javascript:void(0)" onclick="document.getElementById('dark_c<?php echo $index; ?>').style.display='block'; document.getElementById('light_c<?php echo $index; ?>').style.display='none'">Ajouter une carte...</a>
            </div>
            <?php
            echo ("</div>");
        }
    ?>
    <div class="col-sm-2 color1">
        <!-- formulaire caché d'ajout de liste -->
        <div id="dark_l" class="white_content">
            <form method="post" action="main.php" name="liste">
                <input name="titre" class="form-control" type="text" placeholder="Ajouter une liste..." required/>
                <input class="btn btn-default btn-success btn-xs" type="submit" value="Entrer" />
                <a class="right" href="javascript:void(0)" onclick="document.getElementById('dark_l').style.display='none'; document.getElementById('light_l').style.display='block'">X</a>
            </form>
        </div>
        <!-- bouton de mise à jour du formulaire -->
        <div id="light_l">
            <a href="javascript:void(0)" onclick="document.getElementById('dark_l').style.display='block'; document.getElementById('light_l').style.display='none'">Ajouter une liste...</a>
        </div>
    </div>
</div>
