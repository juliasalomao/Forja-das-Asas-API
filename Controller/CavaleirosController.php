<?php
namespace Controller;

require_once __DIR__ . 
'/../Model/Cavaleiros.php';

use Model\Cavaleiros;

class CavaleirosController
{
    public function getAll()
    {
        $cavaleiros = Cavaleiros::getAll();
        if ($cavaleiros) {
            http_response_code(200 );
            echo json_encode($cavaleiros);
        } else {
            http_response_code(404 );
            echo json_encode(["message" => "Nenhum cavaleiro encontrado"]);
        }
    }

    public function getById($id)
    {
        $cavaleiro = Cavaleiros::getById($id);
        if ($cavaleiro) {
            http_response_code(200 );
            echo json_encode($cavaleiro);
        } else {
            http_response_code(404 );
            echo json_encode(["message" => "Cavaleiro não encontrado"]);
        }
    }

    public function create($data)
    {
        if (isset($data["nome"]) && isset($data["patente"]) && isset($data["elemento"])) {
            if (Cavaleiros::create($data)) {
                http_response_code(201 );
                echo json_encode(["message" => "Cavaleiro criado com sucesso"]);
            } else {
                http_response_code(500 );
                echo json_encode(["message" => "Erro ao criar cavaleiro"]);
            }
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    public function update($id, $data)
    {
        if (isset($data["nome"]) && isset($data["patente"]) && isset($data["elemento"])) {
            if (Cavaleiros::update($id, $data)) {
                http_response_code(200 );
                echo json_encode(["message" => "Cavaleiro atualizado com sucesso"]);
            } else {
                http_response_code(500 );
                echo json_encode(["message" => "Erro ao atualizar cavaleiro"]);
            }
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    public function delete($id)
    {
        if (Cavaleiros::delete($id)) {
            http_response_code(200 );
            echo json_encode(["message" => "Cavaleiro excluído com sucesso"]);
        } else {
            http_response_code(500 );
            echo json_encode(["message" => "Erro ao excluir cavaleiro"]);
        }
    }
}
