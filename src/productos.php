<?php
require_once "src/db.php";
$metodo = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = $uri[1] ?? null;


switch ($metodo) {
    case 'GET':
        // Realizar SELECT
        if ($id != null) {
            $stm1 = $pdo->prepare("SELECT id, nombre, precio, categoria_id FROM productos WHERE id = ?");
            $stm1->execute([$id]);
            $response = $stm1->fetch(PDO::FETCH_ASSOC);
        
            if ($response) {
                echo json_encode($response);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 404, 'errorUrl' => 'https://http.cat/images/404.jpg']);
            }
        } else {
        $stm = $pdo->prepare("SELECT id, nombre, precio, categoria_id FROM productos");
        $stm->execute();
        $response = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($response);
        }
        
        break;
    
}