<?php
require_once "src/db.php";
$metodo = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = $uri[1] ?? null;


switch ($metodo) {
    case 'GET':
        $stm = $pdo->prepare("SELECT id, nombre FROM categorias");
        $stm->execute();
        $response = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($response);

        break;
    
}