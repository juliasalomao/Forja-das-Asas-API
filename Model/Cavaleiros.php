<?php
namespace Model;

require_once __DIR__ . '/Connection.php';

use PDO;

class User
{
    public static function getAll()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT * FROM cavaleiros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cavaleiros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("INSERT INTO cavaleiros (nome, patente, elemento) VALUES (?, ?, ?)");
        return $stmt->execute([$data['nome'], $data['patente'], $data['elemento']]);
    }

    public static function update($id, $data)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("UPDATE cavaleiros SET nome = ?, patente = ?, elemento = ? WHERE id = ?");
        return $stmt->execute([$data['nome'], $data['patente'], $data['elemento'], $id]);
    }

    public static function delete($id)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("DELETE FROM cavaleiros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
