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
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stm = $pdo->prepare("INSERT INTO categorias(nombre) VALUES(?)");
        $stm->execute([
            $data['nombre']
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
        $stm = $pdo->prepare("UPDATE categorias SET id=?, nombre=? WHERE id = ?");
        $stm->execute(
            [
                $data['id'],
                $data['nombre'],
                $id
            ]
        );
        echo json_encode($data);
        break;
     case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID no encontrado', 'code' => 404, 'errorUrl' => 'https://http.cat/images/404.jpg']);
            exit;
        }
        $stm1 = $pdo->prepare("SELECT id, nombre FROM categorias WHERE id=?");
        $stm1->execute([
            $id,
        ]);
        $stm1->execute();
        $response = $stm1->fetch(PDO::FETCH_ASSOC);
        $stm = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
        $stm->execute([
            $id,
        ]);
        if ($stm->rowCount() > 0) {
            echo json_encode($response);
        }else{
            http_response_code(400);
            echo json_encode(['error' => 'No se pudo eliminar este registro porque no existe', 'code' => 400, 'errorUrl' => 'https://http.cat/images/400.jpg']);
            exit;
        }
        break;
}