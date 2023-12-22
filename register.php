<?php
include("header.php");
?>

<div class="requete">
    <h1 class="titre">Inscrivez-vous dès maintenant ! 😎</h1>
    <form action="traiteregister.php" method="get">
        <legend>Les champs renseignez avec une <span id="red">*</span> sont obligatoires</legend>
        <label for="pseudo">Saisissez votre pseudonyme<span id="red">*</span> </label>
        <input type="text" name="pseudo" id="pseudo" placeholder="Ex : JohnDoe" required>

        <label for="email">Saisissez votre login (adresse mail)<span id="red">*</span></label>
        <input type="email" name="email" id="email" placeholder="Ex : johndoe@gmail.com" required>


        <label for="password">Saisissez votre mot de passe<span id="red">*</span></label>
        <input type="password" name="password" id="password" placeholder="Ex : 123" required>


        <label for="password2"> Saisissez votre mot de passe de nouveau<span id="red">*</span></label>
        <input type="password" name="password2" id="password2" placeholder="Ex : 123" required>

        <button type="submit">S'inscrire</button>
        <?php
        if (isset($_GET['erreur'])) {
            $err = $_GET['erreur'];

            echo "<p style='color:red'>Les mots de passes rentrés ne correspondent pas l'un à l'autre</p>";
        }
        ?>
    </form>
    <a href="login.php">Je souhaite me connecter</a>
    <a href="accueil.php">Accéder au blog sans s'inscire</a>
</div>