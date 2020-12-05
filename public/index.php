<?php

require __DIR__ . '/../vendor/autoload.php';

$caminho = $_SERVER['PATH_INFO'];
$rotas = require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
} else {
    session_start();

    $ehRotaDeLogin = stripos($caminho, 'login');
    if (!isset($_SESSION['logado']) && $ehRotaDeLogin === false){
        header('Location: /login');
        exit();
    } else {
        $classeControladora = $rotas[$caminho];
        $controlador = new $classeControladora();
        $controlador->processaRequisicao();
    }
}
