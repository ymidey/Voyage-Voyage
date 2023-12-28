<?php

if (isset($_SERVER['HTTP_REFERER'])) {
    // Récupèration de l'URL de la page précédente
    $urlPagePrecedente = $_SERVER['HTTP_REFERER'];
}
session_start();

$_SESSION = array();

// Destruction de la session
session_destroy();

session_unset();

// Redirection vers la page précédente
header("Location:" . $urlPagePrecedente);
exit();
