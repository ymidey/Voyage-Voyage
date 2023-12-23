<?php

if (isset($_SERVER['HTTP_REFERER'])) {
    // Récupère l'URL de la page précédente
    $urlPagePrecedente = $_SERVER['HTTP_REFERER'];
}
session_start(); // Assurez-vous d'appeler session_start() au début de chaque script qui utilise des sessions

// Effacer toutes les variables de session
$_SESSION = array();

// Destruction de la session
session_destroy();

// Assurez-vous que toutes les données de session sont supprimées
session_unset();

// Redirection vers la page de connexion
header("Location:" . $urlPagePrecedente);
exit();
