<form action="traitebillet.php" method="get" style="display:flex; flex-direction:column; align-items:center">
    <label for="titreBillet">Entrez votre titre
        <input type="text" name="titreBillet" id="titreBillet" required>
    </label>
    <label for="contenu">Entrez le contenu
        <input type="text" name="contenu" id="contenu" required>
    </label>
    <input type="hidden" name="requete" id="requete" value="insert">

    <button type="submit" style="width:30%">Ajout du billet</button>
</form>