<?php

include("connectdb.php");

// Fonction pour récupérer les x derniers billets de la base de données 
function getDerniersBillets($limit)
{
    global $db;
    $requeteBillet = "SELECT * FROM billets, utilisateurs WHERE billets.id_user = utilisateurs.id ORDER BY billets.id_billet DESC LIMIT :nb_billet";
    $prep = $db->prepare($requeteBillet);
    $prep->bindValue(':nb_billet', $limit, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer tout les billets de la base de données
function getAllBillets()
{
    global $db;
    $requeteBillet = "SELECT * FROM billets, utilisateurs WHERE billets.id_user = utilisateurs.id ORDER BY billets.id_billet DESC";
    $stmt = $db->query($requeteBillet);
    return $stmt->fetchall(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer le billet correspondant à l'id envoyé en paramèetre ainsi que tout les commentaires qui lui sont attribués
function getBilletComment($idBillet)
{
    global $db;
    $requeteBilletComments = "
    SELECT 
        billets.*, 
        utilisateurs.pseudo AS auteur,
        utilisateurs.id AS id_user,
        commentaires.id_commentaire,
        commentaires.contenu AS commentaire_contenu,
        commentaires.date_publication AS commentaire_date,
        utilisateurs_commentaires.pseudo AS commentaire_auteur_pseudo,
        utilisateurs_commentaires.id AS commentaire_auteur_id 
    FROM billets
    INNER JOIN utilisateurs ON billets.id_user = utilisateurs.id
    LEFT JOIN commentaires ON billets.id_billet = commentaires.id_Billets
    LEFT JOIN utilisateurs AS utilisateurs_commentaires ON commentaires.id_user = utilisateurs_commentaires.id
    WHERE billets.id_billet = :id_billet
    ORDER BY commentaires.date_publication DESC
";

    $prep = $db->prepare($requeteBilletComments);
    $prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour compter le nombre de commentaire que contient un billet
function getCountComment($idBillet)
{
    global $db;
    $requeteCountComment = "
    SELECT COUNT(commentaires.id_commentaire) AS nombre_commentaires 
    FROM billets 
    LEFT JOIN commentaires ON billets.id_billet = commentaires.id_Billets
    WHERE billets.id_billet = :id_billet
";

    $prep = $db->prepare($requeteCountComment);
    $prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupéer le billet ayant l'id récupérer en paramètre
function getBillet($idBillet)
{
    global $db;
    // Récupérer les données du billet à modifier
    $requeteBillet = "SELECT * FROM billets WHERE id_billet = :id_billet";
    $prep = $db->prepare($requeteBillet);
    $prep->bindValue(':id_billet', $idBillet, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer toutes les données de l'ensemble des utilisateurs de la bdd
function getAllUsers()
{
    global $db;
    $requeteShowUtillisateurs = "SELECT * FROM utilisateurs";
    $stmt = $db->query($requeteShowUtillisateurs);
    return $stmt->fetchall(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer tout les commentaires de la bdd
function getAllComments()
{
    global $db;
    $requeteShowAllComments = "SELECT commentaires.*, utilisateurs.pseudo, billets.titre, billets.id_billet FROM commentaires, utilisateurs, billets WHERE commentaires.id_user = utilisateurs.id && billets.id_billet = commentaires.id_Billets ORDER BY commentaires.date_publication DESC";
    $stmt = $db->query($requeteShowAllComments);
    return $stmt->fetchall(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter un commentaire à un billet
function addComment($id_billet, $commentaire, $datePubli)
{
    global $db;
    $requete = "INSERT INTO commentaires (id_Billets, id_user, contenu, date_publication) VALUES (:id_billet, :id_user, :contenu, :date_publication)";
    $prep = $db->prepare($requete);
    $prep->bindParam(':id_user', $_SESSION["id_user"], PDO::PARAM_INT);
    $prep->bindParam(':id_billet', $id_billet, PDO::PARAM_INT);
    $prep->bindParam(':contenu', $commentaire, PDO::PARAM_STR);
    $prep->bindParam(':date_publication', $datePubli->format("Y-m-d H-i-s"), PDO::PARAM_STR);
    $prep->execute();
}

// Fonction pour supprimer un commentaire
function deleteComment($id_comment)
{
    global $db;
    $requete = "DELETE FROM commentaires WHERE id_commentaire = :id";
    $prep = $db->prepare($requete);
    $prep->bindParam(':id', $id_comment, PDO::PARAM_INT);
    $prep->execute();
}

// Fonction pour mettre à jour un commentaire
function updateComment($id_comment, $nouveauContenu)
{
    global $db;
    $requeteModifComment = "UPDATE commentaires SET contenu = :contenu WHERE id_commentaire = :id_commentaire";
    $prep = $db->prepare($requeteModifComment);
    $prep->bindValue(':id_commentaire', $id_comment, PDO::PARAM_INT);
    $prep->bindValue(':contenu', $nouveauContenu, PDO::PARAM_STR);
    $prep->execute();
}

// Fonction pour supprimer un utilisateur spécifique en fonction de son id, de la bdd
function deleteUser($idUser)
{
    global $db;
    $requete = "DELETE utilisateurs, commentaires FROM utilisateurs
            LEFT JOIN commentaires ON commentaires.id_user = utilisateurs.id
            WHERE utilisateurs.id = :id";
    $prep = $db->prepare($requete);
    $prep->bindValue(':id', $idUser, PDO::PARAM_INT);
    $prep->execute();
}

// Fonction pour récupérer un billet en fonction d'un titre spécifique
function getBilletWithSpecificTitle($titre)
{
    global $db;
    // On vérifie si un billet existe déjà
    $checkTitreBilletExiste = "SELECT id_billet FROM billets WHERE titre = :titre";
    $prep = $db->prepare($checkTitreBilletExiste);
    $prep->bindValue(':titre', $titre, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter un nouveau billet à la bdd
function addBillet($id_user, $titre, $contenu, $date_publi)
{
    global $db;
    $requete = "INSERT INTO billets (id_user, titre, contenu, date) VALUES (:id_user, :titre, :contenu, :date_publication)";
    $prep = $db->prepare($requete);
    $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $prep->bindValue(':titre', $titre, PDO::PARAM_STR);
    $prep->bindValue(':contenu', $contenu, PDO::PARAM_STR);
    $prep->bindValue(':date_publication', $date_publi, PDO::PARAM_STR);
    $prep->execute();
}

// Fonction pour supprimer un billet spécifique selectionné en fonction de son id
function deleteBillet($id_billet)
{
    global $db;
    $requete = "DELETE FROM billets WHERE id_billet = :id_billet";
    $prep = $db->prepare($requete);
    $prep->bindValue(':id_billet', $id_billet, PDO::PARAM_STR);
    $prep->execute();
}

// Fonction pour modifié un billet de la bdd en fonction de son id
function updateBillet($id_billet, $nouveauTitre, $nouveauContenu)
{
    global $db;
    $requeteModifBillet = "UPDATE billets SET titre = :titre, contenu = :contenu WHERE id_billet = :id_billet";
    $prep = $db->prepare($requeteModifBillet);
    $prep->bindValue(':id_billet', $id_billet, PDO::PARAM_INT);
    $prep->bindValue(':titre', $nouveauTitre, PDO::PARAM_STR);
    $prep->bindValue(':contenu', $nouveauContenu, PDO::PARAM_STR);
    $prep->execute();
}

// Fonction pour récuperer l'ensemble des données d'un utilisateur spécifique en fonction de son adresse mail (login)
function getLogin($login)
{
    global $db;
    $requeteLogin = "SELECT * FROM utilisateurs WHERE login= :login";
    $prep = $db->prepare($requeteLogin);
    $prep->bindValue(':login', $login, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récuperer l'ensemble des données d'un utilisateur spécifique en fonction de son pseudo
function getUserWithSpecificPseudo($pseudo)
{
    global $db;
    $checkPseudoExist = "SELECT id FROM utilisateurs WHERE pseudo = :pseudo";
    $prep = $db->prepare($checkPseudoExist);
    $prep->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter un nouvel utilisateur à la bdd
function addUser($pseudo, $login, $mdp)
{
    global $db;
    $requeteRegister = "INSERT INTO utilisateurs VALUES(NULL, :login, :mdp, :pseudo, 0)";
    $prep = $db->prepare($requeteRegister);
    $prep->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $prep->bindValue(':login', $login, PDO::PARAM_STR);

    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    $prep->bindValue(':mdp', $hash, PDO::PARAM_STR);

    $prep->execute();
}
