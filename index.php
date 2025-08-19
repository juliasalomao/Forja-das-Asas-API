<?php
require_once __DIR__ . 
'/vendor/autoload.php';

use Controller\CavaleirosController;

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';
$id = $_GET['id'] ?? null;

$controller = new CavaleirosController();

// Se a rota for 'cavaleiros' OU a rota estiver vazia (URL base)
if ($path === 'cavaleiros' || $path === '') {
    switch ($method) {
        case 'GET':
            // Se a rota estiver vazia, chama getAll() para listar todos os cavaleiros
            // Se houver um ID, chama getById()
            // Caso contrário (path é 'cavaleiros' mas sem ID), também chama getAll()
            if ($path === '' || !$id) {
                $controller->getAll();
            } else {
                $controller->getById($id);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $controller->create($data);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
            break;

        case 'DELETE':
            $controller->delete($id);
            break;

        default:
            http_response_code(405 );
            echo json_encode(['error' => 'Método não permitido']);
            break;
    }
} else {
    // Se a rota não for 'cavaleiros' e não estiver vazia, retorna 404
    http_response_code(404 );
    echo json_encode(['error' => 'Rota não encontrada']);
}

