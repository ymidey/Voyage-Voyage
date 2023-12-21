<?php
include("header.php");
?>

<div class="header">
    <h1 class="titre">Ajout d'un nouveau billet sur le forum</h1>
</div>
<form action="traitebillet.php" method="get" style="display:flex; flex-direction:column; align-items:center">
    <label for="titreBillet">Titre
        <input type="text" name="titreBillet" id="titreBillet" required>
    </label>
    <label for="contenu">Contenu
        <input type="text" name="contenu" id="contenu" required>
    </label>
    <input type="hidden" name="requete" id="requete" value="insert">

    <button type="submit" style="width:30%">Publier le billet</button>
</form>