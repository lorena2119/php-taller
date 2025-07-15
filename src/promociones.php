<?php
require_once "src/db.php";
$metodo = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = $uri[1] ?? null;


switch ($metodo) {
    case 'GET':
        $stm = $pdo->prepare("SELECT id, descripcion, descuento, producto_id FROM promociones");
        $stm->execute();
        $response = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($response);

        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stm = $pdo->prepare("INSERT INTO promociones(descripcion, descuento, producto_id) VALUES(?, ?, ?)");
        $stm->execute([
            $data['descripcion'],
            $data['descuento'],
            $data['producto_id']
        ]);
        http_response_code(201);
        $data['id'] = $pdo->lastInsertId();
        echo json_encode($data);
        break;
   case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID no encontrado', 'code' => 404, 'errorUrl' => 'https://http.cat/images/404.jpg']);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $stm = $pdo->prepare("UPDATE promociones SET id=?, descripcion=?, descuento=?, producto_id=? WHERE id = ?");
        $stm->execute(
            [
                $data['id'],
                $data['descripcion'],
                $data['descuento'],
                $data['producto_id'],
                $id
            ]
        );
        echo json_encode($data);
        break;
     
}