<?php

namespace app\Models;

use PDO;

class Produto {
    private PDO $db;

    public function __construct() {
        $caminhoDatabase = __DIR__ . '/../../config/Database.php';

        if (file_exists($caminhoDatabase)) {
            require_once $caminhoDatabase;
        }

        $this->db = \config\Database::getConnection();
    }

    public function listar(): array {
        $sql = "SELECT * FROM produtos ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function buscarPorId(int $id): ?array {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $produto = $stmt->fetch();
        return $produto ?: null;
    }

    public function criar(array $dados): bool {
        $sql = "INSERT INTO produtos (nome, preco_custo, preco_venda, estoque_atual, estoque_minimo, imagem_url) 
                VALUES (:nome, :preco_custo, :preco_venda, :estoque_atual, :estoque_minimo, :imagem_url)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome'           => $dados['nome'],
            ':preco_custo'   => $dados['preco_custo'],
            ':preco_venda'   => $dados['preco_venda'],
            ':estoque_atual' => $dados['estoque_atual'],
            ':estoque_minimo' => $dados['estoque_minimo'],
            ':imagem_url'     => $dados['imagem_url']
        ]);
    }

    public function atualizar(int $id, array $dados): bool {
        $sql = "UPDATE produtos 
                SET nome = :nome, 
                    preco_custo = :preco_custo, 
                    preco_venda = :preco_venda, 
                    estoque_atual = :estoque_atual, 
                    estoque_minimo = :estoque_minimo, 
                    imagem_url = :imagem_url 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'             => $id,
            ':nome'           => $dados['nome'],
            ':preco_custo'   => $dados['preco_custo'],
            ':preco_venda'   => $dados['preco_venda'],
            ':estoque_atual' => $dados['estoque_atual'],
            ':estoque_minimo' => $dados['estoque_minimo'],
            ':imagem_url'     => $dados['imagem_url']
        ]);
    }

    public function deletar(int $id): bool {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}