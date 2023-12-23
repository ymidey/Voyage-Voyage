<?php
include("header.php");

$idBillet = $_GET["id_billet"];

$requeteBilletComments = "
    SELECT 
        billets.*, 
        utilisateurs.pseudo AS auteur,
        utilisateurs.id AS id_user,
        commentaires.id_commentaire,
        commentaires.contenu AS commentaire_contenu,
        commentaires.date_publication AS commentaire_date,
        utilisateurs_commentaires.pseudo AS commentaire_auteur_pseudo
    FROM billets
    INNER JOIN utilisateurs ON billets.id_user = utilisateurs.id
    LEFT JOIN commentaires ON billets.id_billet = commentaires.id_Billets
    LEFT JOIN utilisateurs AS utilisateurs_commentaires ON commentaires.id_user = utilisateurs_commentaires.id
    WHERE billets.id_billet = :id_billet
    ORDER BY commentaires.date_publication DESC
";

$prep = $db->prepare($requeteBilletComments);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute();
$resultBilletComments = $prep->fetchAll(PDO::FETCH_ASSOC);

$requeteCountComment = "
    SELECT COUNT(commentaires.id_commentaire) AS nombre_commentaires 
    FROM billets 
    LEFT JOIN commentaires ON billets.id_billet = commentaires.id_Billets
    WHERE billets.id_billet = :id_billet
";

$prep = $db->prepare($requeteCountComment);
$prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
$prep->execute();
$resultCountComment = $prep->fetchAll(PDO::FETCH_ASSOC);
var_dump($_SESSION)
?>

<div class="showBillet">
    <a href="archive.php" class="returnproject"><svg width=" 25px" height="25px" viewBox="0 0 25 25" ">
            <path d=" M24 12.001H2.914l5.294-5.295-.707-.707L1 12.501l6.5 6.5.707-.707-5.293-5.293H24v-1z"></path>
        </svg>Retour à la page précédente</a>
    <?php if ($resultBilletComments) { ?>
    <?php if ($resultBilletComments) { ?>
    <article class="billet">
        <div class="billet-header">
            <h1><?php echo $resultBilletComments[0]["titre"]; ?></h1>

            <?php
                    $dateObj = new DateTime($resultBilletComments[0]["date"]);
                    $formattedDate = $dateObj->format('d M, Y');
                    ?>

            <h2>Publié le <?php echo $formattedDate; ?> par <?php echo $resultBilletComments[0]["auteur"]; ?></h2>
        </div>

        <div class="billet-content">
            <p><?php echo $resultBilletComments[0]["contenu"]; ?></p>
        </div>
    </article>
    <?php } else { ?>
    <p>Aucun résultat trouvé.</p>
    <?php } ?>
    <button id="showComment">Voir les commentaires</button>
    <div id="commentaire">
        <?php
            echo "<p>" . $resultCountComment[0]["nombre_commentaires"] . " Commentaire(s) : </p>";

            if ($resultBilletComments[0]["commentaire_contenu"]) {
                foreach ($resultBilletComments as $row) {
                    $dateObj = new DateTime($row["commentaire_date"]);
                    $formattedDateTime = $dateObj->format('d M, Y \à H:i');

                    echo "<div class='comments'>";
                    echo "<p class='comments-header'>";
                    echo "Publié par " . $row["commentaire_auteur_pseudo"] . " le " . $formattedDateTime;
                    echo "</p>";

                    // Vérifier si l'utilisateur actuel est l'auteur du commentaire
                    $isAuthor = isset($_SESSION["id_user"]) && $_SESSION["id_user"] == $row["id_user"];

                    if ($isAuthor) {
                        // Afficher le commentaire sous forme de paragraphe
                        echo "<div id='commentContent{$row['id_commentaire']}'>";
                        echo "<p>" . $row["commentaire_contenu"] . "</p>";
                        echo "</div>";

                        // Afficher un formulaire caché
                        echo "<form id='commentForm{$row['id_commentaire']}' action='traite-com.php' method='post' style='display:none;'>";
                        echo "<textarea name='nouveau_contenu' required>" . $row["commentaire_contenu"] . "</textarea>";
                        echo "<input type='hidden' name='id_commentaire' value='" . $row['id_commentaire'] . "'>";
                        echo "<input type='submit' value='Modifier'>";
                        echo "</form>";

                        // Bouton pour afficher/masquer le formulaire
                        echo "<button id='toggleFormButton{$row['id_commentaire']}' onclick='toggleCommentForm({$row['id_commentaire']})'>Modifier le commentaire</button>";

                        // Script JavaScript pour basculer entre le paragraphe et le formulaire
                        echo "<script>
                    function toggleCommentForm(commentId) {
                        document.getElementById('commentContent' + commentId).style.display = 'none';
                        document.getElementById('commentForm' + commentId).style.display = 'block';
                    }
                </script>";
                    } else {
                        // Afficher le contenu du commentaire
                        echo "<p>" . $row["commentaire_contenu"] . "</p>";
                    }

                    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
                        echo "<a href='traite-com.php?id_billet=" . $idBillet . "&requete=delete&idcom=" . $row['id_commentaire'] . "' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');\">Supprimer le commentaire</a>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p>Il n'y a aucun commentaire d'écrit pour ce billet</p>";
            }
            ?>



        <?php if (isset($_SESSION["id_user"])) { ?>
        <form action="traite-com.php" method="get" class="requete form-com">
            <label for="com">Ajoutez un nouveau commentaire : </label>
            <textarea name="com" id="com" required></textarea>
            <input type="hidden" name="id_billet" value="<?php echo $idBillet; ?>">
            <input type="hidden" name="requete" id="requete" value="insert">
            <button type="submit" id="btn_post_com">Postez</button>
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