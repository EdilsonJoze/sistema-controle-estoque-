<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $host     = 'localhost';
            $dbname   = 'sistema_estoque';
            $user     = 'root';
            $password = '';

            try {
                self::$connection = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8",
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                // Em produção, deve-se registrar o log e exibir mensagem genérica
                die('Erro de conexão com o banco de dados.');
            }
        }

        return self::$connection;
    }
}