<?php
require_once __DIR__ . '/vendor/autoload.php';

use Controller\CavaleirosController;

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';
$id = $_GET['id'] ?? null;

$controller = new CavaleirosController();

if ($path === '') {
    echo json_encode([
        'mensagem' => 'Bem-vindo à API Forja das Asas!',
        'endpoints_disponiveis' => [
            '/?path=cavaleiros' => 'Lista todos os cavaleiros (GET)',
            '/?path=cavaleiros&id={id}' => 'Obtém um cavaleiro específico (GET)',
            '/?path=cavaleiros' => 'Cria um novo cavaleiro (POST)',
            '/?path=cavaleiros&id={id}' => 'Atualiza um cavaleiro (PUT)',
            '/?path=cavaleiros&id={id}' => 'Deleta um cavaleiro (DELETE)'
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($path === 'cavaleiros') {
    switch ($method) {
        case 'GET':
            if ($id) {
                $controller->getById($id);
            } else {
                $controller->getAll();
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
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);
}
