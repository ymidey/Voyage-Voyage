<?php
include("header.php");


$idBillet = $_GET["id"];
$requeteBilletUser = "SELECT * FROM billets, utilisateurs WHERE billets.id_billet = :id_billet AND billets.id_user = utilisateurs.id";

$prep = $db->prepare($requeteBilletUser);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute(); // Exécute la requête
$resultRequetBilletUser = $prep->fetch(PDO::FETCH_ASSOC);

$requeteShowComment = "SELECT DISTINCT commentaires.id, commentaires.contenu, commentaires.date_publication, utilisateurs.pseudo 
                      FROM billets
                      INNER JOIN commentaires ON commentaires.id_Billets = billets.id_billet
                      INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_user 
                      WHERE billets.id_billet = :id_billet ORDER BY commentaires.date_publication DESC";
$prep = $db->prepare($requeteShowComment);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute(); // Exécute la requête
$resultShowComment = $prep->fetchall(PDO::FETCH_ASSOC);
?>

<div class="showBillet">
    <?php if ($resultRequetBilletUser) { ?>
        <div class="billet">
            <div class="billet-header">
                <h1><?php echo $resultRequetBilletUser["titre"] ?></h1>
                <?php
                $dateObj = new DateTime($resultRequetBilletUser["date"]);
                $formattedDate = $dateObj->format('M d, Y');
                ?>

                <h2><?php echo $resultRequetBilletUser["pseudo"] ?> - <?php echo $formattedDate ?></h2>
            </div>
            <div class="billet-content">
                <p><?php echo $resultRequetBilletUser["contenu"] ?></p>
            </div>

        </div>
        <button id="showComment">Voir les commentaires</button>
        <div id="commentaire">
            <p>Commentaire : </p>
            <?php if ($resultShowComment) {
                foreach ($resultShowComment as $comment) { ?>
                    <div class="comments">
                        <p class="comments-header">
                            <?php echo "Publié par " . $comment["pseudo"] . " le " . $comment["date_publication"] ?> </p>
                        <p>
                            <?php echo $comment["contenu"] ?>
                        </p>
                    </div>
            <?php }
            } else {
                echo "<p>Il n'y a aucun commentaire d'écrit pour ce billet</p>";
            } ?>

            <?php if (isset($_SESSION["id_user"])) { ?>
                <form action="traite-com.php" method="get">
                    <div class="form-element">
                        <label for="com">Ajoutez un nouveau commentaire</label>
                        <input type="textarea" name="com" id="com">
                    </div>
                    <input type="hidden" name="id_billet" value="<?php echo $idBillet; ?>">
                    <input type="submit" value="Poster" id="btn_post_com">
                </form>
            <?php } else {
                echo "<br><div><p>Pour pouvoir ajouter un commentaire, vous devez être connecter</p><a href='login.php'>Me connecter</a></div>";
            } ?>
        </div>

    <?php  } else { ?>
        <p>Aucun résultat trouvé.</p>
    <?php } ?>
</div>
<?php include("footer.php"); ?>