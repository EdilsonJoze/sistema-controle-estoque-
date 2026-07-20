<?php

namespace App\Models;

class Usuario {
    private int $id;
    private string $nome;
    private string $email;

    public function __construct(int $id = 0, string $nome = '', string $email = '') {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
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

    /**
     * Exemplo de método simulado para retornar dados 
     * (Será integrado ao PDO / Banco de Dados na próxima entrega)
     */
    public static function all(): array {
        return [
            new Usuario(1, 'Edilson Jr', 'edilson@email.com'),
            new Usuario(2, 'Maria Silva', 'maria@email.com'),
        ];
    }
}