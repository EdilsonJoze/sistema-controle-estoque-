<?php

namespace app\Models;

use PDO;

class Usuario {
    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private string $perfil;

    public function __construct(
        int $id = 0, 
        string $nome = '', 
        string $email = '', 
        string $senha = '', 
        string $perfil = 'usuario'
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->perfil = $perfil;
    }

    // Getters e Setters
    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function getPerfil(): string { return $this->perfil; }
    public function setPerfil(string $perfil): void { $this->perfil = $perfil; }

    // --- MÉTODOS DE BANCO DE DADOS (PDO) ---

    private static function getDB(): PDO {
        if (!class_exists('config\Database') && !class_exists('Config\Database')) {
            $baseDir = dirname(__DIR__, 2);
            $caminhos = [
                $baseDir . '/config/Database.php',
                $baseDir . '/Config/Database.php',
                $baseDir . '/config/database.php'
            ];

            foreach ($caminhos as $caminho) {
                if (file_exists($caminho)) {
                    require_once $caminho;
                    break;
                }
            }
        }

        if (class_exists('config\Database')) {
            return \config\Database::getConnection();
        }

        return \Config\Database::getConnection();
    }

    public static function buscarPorEmail(string $email): ?array {
        $db = self::getDB();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $usuario ?: null;
    }

    public static function criar(array $dados): bool {
        $db = self::getDB();
        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':nome'   => $dados['nome'],
            ':email'  => $dados['email'],
            ':senha'  => password_hash($dados['senha'], PASSWORD_DEFAULT),
            ':perfil' => $dados['perfil'] ?? 'usuario'
        ]);
    }

    public static function all(): array {
        $db = self::getDB();
        $sql = "SELECT id, nome, email, perfil FROM usuarios";
        $stmt = $db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}