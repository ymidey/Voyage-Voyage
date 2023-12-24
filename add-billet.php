<?php
include("header.php");

if ($_SESSION['admin'] == 1) {
?>
    <div class="requete">
        <h1 class="titre">Ajout d'un nouveau billet sur le forum</h1>

        <form action="traitebillet.php" method="get">

            <label for="titreBillet">Titre</label>
            <input type="text" name="titreBillet" id="titreBillet" required>
            <label for="contenu">Contenu</label>
            <textarea name="contenu" id="contenu" required></textarea>

            <input type="hidden" name="requete" id="requete" value="insert">

            <button type="submit">Publier le billet</button>
        </form>

        <?php if (isset($_GET["erreur"]) && $_GET["erreur"] == "titreExiste") {
            echo "<p style='color:red'>Le titre que vous avez donné à votre billet existe déjà<, veuillez en choisir un autre/p>";
        } ?>
    </div>
<?php } else {
    header("Location: accueil.php");
} ?>