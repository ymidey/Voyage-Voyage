<?php
include("header.php");

if (
    isset($_GET["requete"])
    &&
    $_SESSION['admin'] == 1
) {
    if (
        $_GET["requete"] == "insert" && isset($_GET['titreBillet']) &&
        isset($_GET['contenu'])
    ) {
        $titre = ($_GET['titreBillet']);
        $contenu = ($_GET['contenu']);
        $contenu = nl2br($contenu);
        $datePubli = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $idUser = $_SESSION['id_user'];

        // On vérifie si un billet existe déjà
        $checkTitreBilletExiste = "SELECT id_billet FROM billets WHERE titre = :titre";
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

            header("Location: accueil.php?validation=insert");
            exit;
        }
    } elseif ($_GET["requete"] == "delete" && isset($_GET['idBillet']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $idBillet = $_GET['idBillet'];

        // Supprimer le billet avec l'ID spécifié
        $requete = "DELETE FROM billets WHERE id_billet = :id_billet";
        $stmt = $db->prepare($requete);
        var_dump($idBillet);
        $stmt->execute(['id_billet' => $idBillet]);

        header("Location: accueil.php?validation=delete");
        exit;
    } elseif ($_GET["requete"] == "update" && isset($_GET['idBillet'])) {
        $idBillet = $_GET['idBillet'];
        $nouveauTitre = $_GET['titre'];
        $nouveauContenu = $_GET['contenu'];
        $nouveauContenu = nl2br($nouveauContenu);


        // Mettre à jour le billet dans la base de données
        $requeteModifBillet = "UPDATE billets SET titre = :titre, contenu = :contenu WHERE id_billet = :id_billet";
        $stmt = $db->prepare($requeteModifBillet);
        $stmt->execute(['id_billet' => $idBillet, 'titre' => $nouveauTitre, 'contenu' => $nouveauContenu]);

        header("Location: accueil.php");
        exit;
    }
} else {
    header("Location: accueil.php");
}
