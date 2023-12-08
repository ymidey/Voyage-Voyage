<form action="traitelogin.php" method="get" style="display:flex; flex-direction:column; align-items:center">
    <label for="email">Votre login (adresse mail)
        <input type="email" name="login" id="login" required>
    </label>
    <label for="password">Votre mot de passe
        <input type="password" name="password" id="password" required>
    </label>
    <button type="submit" style="width:30%">Se connecter</button>
    <?php
    if (isset($_GET['erreur'])) {
        $err = $_GET['erreur'];

        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
    }
    ?>
    <a href="register.php">S'inscrire</a>
    <a href="accueil.php">Accéder au blog sans se connecter</a>

</form>