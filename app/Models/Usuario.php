<?php

namespace App\Models;

use Config\Database;
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
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPerfil(): string {
        return $this->perfil;
    }

    public function setPerfil(string $perfil): void {
        $this->perfil = $perfil;
    }

    // --- MÉTODOS DE BANCO DE DADOS (PDO) ---

    // Retorna a conexão com o banco
    private static function getDB(): PDO {
        return Database::getConnection();
    }

    // Busca usuário pelo e-mail para validar o login
    public static function buscarPorEmail(string $email): ?array {
        $db = self::getDB();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $usuario ?: null;
    }

    // Cadastra um novo usuário salvando a senha com hash seguro (BCRYPT)
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

    // Lista todos os usuários cadastrados no banco
    public static function all(): array {
        $db = self::getDB();
        $sql = "SELECT id, nome, email, perfil FROM usuarios";
        $stmt = $db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
