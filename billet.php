<?php
include("header.php");


$idBillet = $_GET["id_billet"];
$requeteBilletUser = "SELECT * FROM billets, utilisateurs WHERE billets.id_billet = :id_billet AND billets.id_user = utilisateurs.id";

$prep = $db->prepare($requeteBilletUser);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute(); // Exécute la requête
$resultRequetBilletUser = $prep->fetch(PDO::FETCH_ASSOC);

$requeteShowComment = "SELECT DISTINCT commentaires.id_commentaire, commentaires.contenu, commentaires.date_publication, utilisateurs.pseudo 
                      FROM billets
                      INNER JOIN commentaires ON commentaires.id_Billets = billets.id_billet
                      INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_user 
                      WHERE billets.id_billet = :id_billet ORDER BY commentaires.date_publication DESC";
$prep = $db->prepare($requeteShowComment);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute(); // Exécute la requête
$resultShowComment = $prep->fetchall(PDO::FETCH_ASSOC);

$requeteCountComment = "SELECT COUNT(commentaires.id_commentaire) AS nombre_commentaires FROM billets INNER JOIN commentaires ON commentaires.id_Billets = billets.id_billet
 WHERE billets.id_billet = :id_billet";
$prep = $db->prepare($requeteCountComment);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute(); // Exécute la requête
$resultCountComment = $prep->fetchall(PDO::FETCH_ASSOC);
?>

<div class="showBillet">
    <?php if ($resultRequetBilletUser) { ?>
    <article class="billet">
        <div class="billet-header">
            <h1><?php echo $resultRequetBilletUser["titre"] ?></h1>
            <?php
                $dateObj = new DateTime($resultRequetBilletUser["date"]);
                $formattedDate = $dateObj->format('d M, Y');
                ?>

            <h2>Publié le <?php echo $formattedDate ?> par <?php echo $resultRequetBilletUser["pseudo"] ?></h2>
        </div>
        <div class="billet-content">
            <p><?php echo $resultRequetBilletUser["contenu"] ?></p>
        </div>

    </article>
    <button id="showComment">Voir les commentaires</button>
    <div id="commentaire">

        <?php
            echo "<p>" . $resultCountComment[0]["nombre_commentaires"] . " Commentaire(s) : </p>" ?>
        <?php if ($resultShowComment) {
                foreach ($resultShowComment as $comment) { ?>
        <div class="comments">
            <?php
                        $dateObj = new DateTime($comment["date_publication"]);
                        $formattedDateTime = $dateObj->format('d M, Y \à H:i');

                        echo "<p class='comments-header'>";
                        echo "Publié par " . $comment["pseudo"] . " le " . $formattedDateTime;
                        echo "</p>";
                        echo $comment["contenu"] ?>
            </p>
            <?php
                        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
                            echo "<a href='traite-com.php?id_billet=" . $idBillet . "&requete=delete&idcom=" . $comment['id_commentaire'] . "'>Supprimer le commentaire</a>";
                        } ?>
        </div>
        <?php }
            } else {
                echo "<p>Il n'y a aucun commentaire d'écrit pour ce billet</p>";
            } ?>

        <?php if (isset($_SESSION["id_user"])) { ?>
        <form action="traite-com.php" method="get">
            <div class="form-element">
                <label for="com">Ajoutez un nouveau commentaire : </label>
                <textarea name="com" id="com" required></textarea>
            </div>
            <input type="hidden" name="id_billet" value="<?php echo $idBillet; ?>">
            <input type="hidden" name="requete" id="requete" value="insert">
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