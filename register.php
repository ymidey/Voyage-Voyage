<form action="traiteregister.php" method="get" style="display:flex; flex-direction:column; align-items:center">
    <label for="email">Entrez votre pseudonyme
        <input type="text" name="pseudo" id="pseudo" required>
    </label>
    <label for="email">Entrez Votre login (adresse mail)
        <input type="email" name="email" id="email" required>
    </label>
    <label for="password">Entrez votre mot de passe
        <input type="password" name="password" id="password" required>
    </label>
    <label for="passwordVerif">Entrez votre mot de passe de nouveau
        <input type="password" name="password2" id="password2" required>
    </label>
    <button type="submit" style="width:30%">S'inscrire</button>
    <?php
    if (isset($_GET['erreur'])) {
        $err = $_GET['erreur'];

        echo "<p style='color:red'>Les mots de passes rentrés ne correspondent pas l'un à l'autre</p>";
    }
    ?>
    <a href="login.php">Me connecter</a>
    <a href="accueil.php">Accéder au blog sans se connecter</a>

</form>