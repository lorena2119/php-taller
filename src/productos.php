<?php
require_once "src/db.php";
$metodo = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = $uri[1] ?? null;


switch ($metodo) {
    case 'GET':
        // Realizar SELECT
        if ($id != null) {
            $stm1 = $pdo->prepare("SELECT p.id, p.nombre, p.precio, p.categoria_id, c.nombre as nombreCategoria, pr.descripcion AS promocion, pr.descuento FROM productos as p INNER JOIN categorias as c ON p.categoria_id = c.id LEFT JOIN promociones as pr ON pr.producto_id = p.id WHERE p.id = ?");
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
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stm = $pdo->prepare("INSERT INTO productos(nombre, precio, categoria_id) VALUES(?, ?, ?)");
        $stm->execute([
            $data['nombre'],
            $data['precio'],
            $data['categoria_id']
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
        $stm = $pdo->prepare("UPDATE productos SET id=?, nombre=?, precio=?, categoria_id =? WHERE id = ?");
        $stm->execute(
            [
                $data['id'],
                $data['nombre'],
                $data['precio'],
                $data['categoria_id'],
                $id
            ]
        );
        echo json_encode($data);
        break;
}