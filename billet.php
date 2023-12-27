<?php
include("header.php");

$idBillet = $_GET["id_billet"];

$resultBilletComments = getBilletComment($idBillet);

$resultCountComment = getCountComment($idBillet);
?>

<div class="showBillet">
    <a href="accueil.php" class="returnproject"><svg width=" 25px" height="25px" viewBox="0 0 25 25" ">
            <path d=" M24 12.001H2.914l5.294-5.295-.707-.707L1 12.501l6.5 6.5.707-.707-5.293-5.293H24v-1z"></path>
        </svg>Retour à la page d'accueil</a>
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
                    <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) { ?>
                        </a>
                        <div class="billet-admin">
                            <a href="traitebillet.php?requete=delete&idBillet=<?php echo $resultBilletComments[0]["id_billet"] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce billet?')">Supprimer le billet</a>
                            <a href="modif-billet.php?idBillet=<?php echo $resultBilletComments[0]["id_billet"] ?>">Modifier le
                                billet</a>
                        </div>
                    <?php }; ?>
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


                    if (isset($_SESSION["id_user"]) && ($_SESSION["id_user"] == $row["commentaire_auteur_id"])) {
                        echo "<div id='commentContent{$row['id_commentaire']}'>";
                        echo "<p>" . $row["commentaire_contenu"] . "</p>";
                        echo "</div>";

                        echo "<form id='commentForm{$row['id_commentaire']}' action='traite-com.php' method='get' style='display:none;'>";
                        echo "<textarea name='nouveau_contenu' required>" . $row["commentaire_contenu"] . "</textarea>";
                        echo "<input type='hidden' name='id_commentaire' value='" . $row['id_commentaire'] . "'>";
                        echo "<input type='hidden' name='requete' value='update'>";
                        echo "<input type='hidden' name='id_billet' value='" . $row["id_billet"] . "'>";

                        echo "<input type='submit' value='Modifier'>";
                        echo "</form>";

                        echo "<button id='toggleFormButton{$row['id_commentaire']}' onclick='toggleCommentForm({$row['id_commentaire']})'>Modifier le commentaire</button>";

                        echo "<script>
    function toggleCommentForm(commentId) {
        var commentContent = document.getElementById('commentContent' + commentId);
        var commentForm = document.getElementById('commentForm' + commentId);
        var button = document.getElementById('toggleFormButton' + commentId);

        if (commentContent.style.display === 'none') {
            // Si la div est cachée, la rendre visible et changer le texte du bouton
            commentContent.style.display = 'block';
            commentForm.style.display = 'none';
            button.innerHTML = 'Modifier le commentaire';
        } else {
            // Si la div est visible, la cacher et changer le texte du bouton
            commentContent.style.display = 'none';
            commentForm.style.display = 'block';
            button.innerHTML = 'Annuler la modification';
        }
    }
</script>";
                    } else {
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