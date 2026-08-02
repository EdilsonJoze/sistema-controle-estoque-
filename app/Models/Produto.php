<?php

namespace App\Models;

use Config\Database;
use PDO;

class Produto {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Read: Recupera a lista completa de produtos
     */
    public function listar(): array {
        $sql = "SELECT p.*, f.nome as fornecedor_nome 
                FROM produtos p 
                LEFT JOIN fornecedores f ON p.fornecedor_id = f.id 
                ORDER BY p.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Create: Insere um novo produto na base de dados
     */
    public function criar(array $dados): bool {
        $sql = "INSERT INTO produtos (nome, preco_custo, preco_venda, estoque_atual, estoque_minimo, imagem_url, fornecedor_id) 
                VALUES (:nome, :preco_custo, :preco_venda, :estoque_atual, :estoque_minimo, :imagem_url, :fornecedor_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome'          => $dados['nome'],
            ':preco_custo'   => $dados['preco_custo'],
            ':preco_venda'   => $dados['preco_venda'],
            ':estoque_atual' => $dados['estoque_atual'],
            ':estoque_minimo' => $dados['estoque_minimo'],
            ':imagem_url'     => $dados['imagem_url'],
            ':fornecedor_id' => $dados['fornecedor_id']
        ]);
    }
}