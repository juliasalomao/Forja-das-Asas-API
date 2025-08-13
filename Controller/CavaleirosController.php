<?php
namespace Controller;

require_once __DIR__ . '/../Model/Cavaleiros.php';

use Model\User;

class CavaleirosController
{
    public static function handleRequest()
    {
        header('Content-Type: application/json; charset=utf-8');

        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_GET['path'] ?? '';

       
        if ($path === 'cavaleiros') {
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        echo json_encode(User::getById($_GET['id']));
                    } else {
                        echo json_encode(User::getAll());
                    }
                    break;

                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    echo json_encode(['success' => User::create($data)]);
                    break;

                case 'PUT':
                    if (!isset($_GET['id'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'ID não fornecido']);
                        return;
                    }
                    $data = json_decode(file_get_contents('php://input'), true);
                    echo json_encode(['success' => User::update($_GET['id'], $data)]);
                    break;

                case 'DELETE':
                    if (!isset($_GET['id'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'ID não fornecido']);
                        return;
                    }
                    echo json_encode(['success' => User::delete($_GET['id'])]);
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Método não permitido']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Rota não encontrada']);
        }
    }
}
