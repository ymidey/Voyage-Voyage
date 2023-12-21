<?php
include("header.php");

if (isset($_GET['idBillet'])) {
    $idBillet = $_GET['idBillet'];

    // Récupérer les données du billet à modifier
    $requeteBillet = "SELECT * FROM billets WHERE id_billet = :id_billet";
    $stmt = $db->prepare($requeteBillet);
    $stmt->execute(['id_billet' => $idBillet]);
    $billet = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($billet) {
?>
        <form action="traitebillet.php" method="get">
            <input type="hidden" name="idBillet" value="<?php echo $billet['id_billet']; ?>">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" value="<?php echo $billet['titre']; ?>"><br>
            <label for="contenu">Contenu :</label>
            <textarea name="contenu"><?php echo $billet['contenu']; ?></textarea><br>
            <input type="hidden" name="requete" id="requete" value="update">

            <input type="submit" value="Modifier">
        </form>
<?php
    } else {
        echo "Billet non trouvé.";
    }
} else {
    echo "ID du billet non spécifié.";
}

include("footer.php");
?>