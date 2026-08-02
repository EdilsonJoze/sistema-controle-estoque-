<?php

namespace App\Controllers;

use App\Models\Produto;

class ProdutoController {
    
    // Read: Exibe a lista de produtos
    public function index(): void {
        $model = new Produto();
        $produtos = $model->listar();

        require_once __DIR__ . '/../Views/produtos/index.php';
    }

    // Exibe o formulário de cadastro
    public function criar(): void {
        require_once __DIR__ . '/../Views/produtos/cadastrar.php';
    }

    // Create: Processa o envio do formulário e upload de imagem
    public function salvar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome           = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_custo   = filter_input(INPUT_POST, 'preco_custo', FILTER_VALIDATE_FLOAT);
            $preco_venda   = filter_input(INPUT_POST, 'preco_venda', FILTER_VALIDATE_FLOAT);
            $estoque_atual  = filter_input(INPUT_POST, 'estoque_atual', FILTER_VALIDATE_INT);
            $estoque_minimo = filter_input(INPUT_POST, 'estoque_minimo', FILTER_VALIDATE_INT);
            $fornecedor_id = filter_input(INPUT_POST, 'fornecedor_id', FILTER_VALIDATE_INT) ?: null;

            $imagem_url = null;

            // Processamento do Upload
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $fileTmp   = $_FILES['imagem']['tmp_name'];
                $fileName  = $_FILES['imagem']['name'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($extension, $extensoesPermitidas)) {
                    $novoNome = md5(time() . $fileName) . '.' . $extension;
                    $destino  = __DIR__ . '/../../public/uploads/' . $novoNome;

                    if (!is_dir(__DIR__ . '/../../public/uploads/')) {
                        mkdir(__DIR__ . '/../../public/uploads/', 0755, true);
                    }

                    if (move_uploaded_file($fileTmp, $destino)) {
                        $imagem_url = '/uploads/' . $novoNome;
                    }
                }
            }

            $model = new Produto();
            $model->criar([
                'nome'           => $nome,
                'preco_custo'   => $preco_custo,
                'preco_venda'   => $preco_venda,
                'estoque_atual'  => $estoque_atual,
                'estoque_minimo' => $estoque_minimo,
                'imagem_url'     => $imagem_url,
                'fornecedor_id' => $fornecedor_id
            ]);

            header('Location: /produtos');
            exit;
        }
    }
}