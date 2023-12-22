<?php
include("header.php");
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
</div>