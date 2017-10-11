<?php

// Choix de l'environnement 'dev' ou 'prod'
$environment = 'dev';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Si le fichier existe, on ne passe pas par le router
if ($url !== '/' && file_exists(__DIR__.'/web'.$url)) {
    return false;
}

if ($environment === 'dev') {
    // DEVELOPPEMENT
    // On modifie certaines variable pour ne pas avoir de problèmes par la suite
    $_SERVER['SCRIPT_NAME'] = '/app_dev.php';
    // On inclue le fichier qui sert de point d'entré pour notre application
    require_once __DIR__.'/web/app_dev.php';
} else {
    // PRODUCTION
    // On modifie certaines variable pour ne pas avoir de problèmes par la suite
    $_SERVER['SCRIPT_NAME'] = '/app.php';
    // On inclue le fichier qui sert de point d'entré pour notre application
    require_once __DIR__.'/web/app.php';
}

