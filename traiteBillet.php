<?php
include("header.php");

if (
    isset($_GET['titreBillet']) &&
    isset($_GET['contenu']) &&
    isset($_SESSION['admin']) &&
    $_SESSION['admin'] == 1
) {
    $titre = ($_GET['titreBillet']);
    $contenu = ($_GET['contenu']);
    $datePubli = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $idUser = $_SESSION['id_user'];

    // On vérifie si un billet existe déjà
    $checkTitreBilletExiste = "SELECT id FROM billets WHERE titre = :titre";
    $checkStmt = $db->prepare($checkTitreBilletExiste);
    $checkStmt->execute(['titre' => $titre]);

    if ($checkStmt->rowCount() > 0) {
        header("location: add-billet.php?erreur=titreExiste");
    } else {
        // Aucun billet avec le même titre, vous pouvez ajouter le nouveau billet
        $requete = "INSERT INTO billets (id_user, titre, contenu, date) VALUES (:id_user, :titre, :contenu, :date_publication)";
        $stmt = $db->prepare($requete);

        $stmt->execute([
            'id_user' => $idUser,
            'titre' => $titre,
            'contenu' => $contenu,
            'date_publication' => $datePubli->format("Y-m-d")
        ]);

        header("Location: accueil.php");
        exit;
    }
} else {
    header("Location: accueil.php");
}
