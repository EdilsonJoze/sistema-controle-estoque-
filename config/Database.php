<?php

namespace config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            try {
                $host = '127.0.0.1';
                $db   = 'sistema_estoque';
                $user = 'root';
                $pass = '';

                self::$instance = new PDO(
                    "mysql:host={$host};dbname={$db};charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die("Erro de Conexão com o Banco: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}