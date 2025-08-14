<?php
namespace Model;

use PDO;
use PDOException;

// Inclui as configurações
require_once __DIR__ . 
'/../Config/configuration.php';

class Connection
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . DB_HOST . 
                    ";dbname=" . DB_NAME . 
                    ";port=" . DB_PORT . 
                    ";charset=utf8mb4",
                    DB_USER,
                    DB_PASSWORD
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die(json_encode([
                    "erro" => "Falha na conexão com o banco de dados",
                    "detalhes" => $e->getMessage()
                ]));
            }
        }

        return self::$connection;
    }
}
