<?php
include("header.php");
?>

<div class="requete">
    <h1 class="titre">Se connecter</h1>
    <form action="traitelogin.php" method="get">

        <label for="login">Votre login (adresse mail)</label>
        <input type="email" name="login" id="login" required>

        <label for="password">Votre mot de passe</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Se connecter</button>
        <?php
        if (isset($_GET['erreur'])) {
            $err = $_GET['erreur'];

            echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
        }
        ?>
    </form>
    <a href="register.php">Je souhaite m'inscrire</a>
    <a href="accueil.php">Accéder au blog sans se connecter</a>
</div>