<?php

namespace App\Controllers;

use App\Models\Produto;

class ProdutoController {

    public function index(): void {
        $model = new Produto();
        $produtos = $model->listar();
        require_once __DIR__ . '/../Views/produtos/index.php';
    }

    public function criar(): void {
        require_once __DIR__ . '/../Views/produtos/cadastrar.php';
    }

    public function salvar(): void {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $preco_custo = filter_input(INPUT_POST, 'preco_custo', FILTER_VALIDATE_FLOAT);
            $preco_venda = filter_input(INPUT_POST, 'preco_venda', FILTER_VALIDATE_FLOAT);
            $estoque_atual = filter_input(INPUT_POST, 'estoque_atual', FILTER_VALIDATE_INT);
            $estoque_minimo = filter_input(INPUT_POST, 'estoque_minimo', FILTER_VALIDATE_INT);

            // Validações básicas
            if (empty($nome) || $preco_venda === false || $estoque_atual === false) {
                $_SESSION['mensagem_erro'] = 'Preencha todos os campos obrigatórios corretamente!';
                header('Location: /produtos/cadastrar');
                exit;
            }

            // Tratamento da imagem
            $imagem_url = $this->uploadImagem($_FILES['imagem'] ?? null);

            $model = new Produto();
            $sucesso = $model->criar([
                'nome' => $nome,
                'preco_custo' => $preco_custo,
                'preco_venda' => $preco_venda,
                'estoque_atual' => $estoque_atual,
                'estoque_minimo' => $estoque_minimo,
                'imagem_url' => $imagem_url
            ]);

            if ($sucesso) {
                $_SESSION['mensagem_sucesso'] = 'Produto cadastrado com sucesso!';
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao cadastrar produto.';
            }

            header('Location: /produtos');
            exit;
        }
    }

    // Exibe a view de edição
    public function editar(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /produtos');
            exit;
        }

        $model = new Produto();
        $produto = $model->buscarPorId($id);

        if (!$produto) {
            session_start();
            $_SESSION['mensagem_erro'] = 'Produto não encontrado.';
            header('Location: /produtos');
            exit;
        }

        require_once __DIR__ . '/../Views/produtos/editar.php';
    }

    // Processa a atualização (Update)
    public function atualizar(): void {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nome = trim($_POST['nome'] ?? '');
            $preco_custo = filter_input(INPUT_POST, 'preco_custo', FILTER_VALIDATE_FLOAT);
            $preco_venda = filter_input(INPUT_POST, 'preco_venda', FILTER_VALIDATE_FLOAT);
            $estoque_atual = filter_input(INPUT_POST, 'estoque_atual', FILTER_VALIDATE_INT);
            $estoque_minimo = filter_input(INPUT_POST, 'estoque_minimo', FILTER_VALIDATE_INT);
            $imagem_atual = $_POST['imagem_atual'] ?? null;

            if (!$id || empty($nome) || $preco_venda === false) {
                $_SESSION['mensagem_erro'] = 'Dados inválidos para edição.';
                header("Location: /produtos/editar?id={$id}");
                exit;
            }

            // Mantém a imagem antiga ou faz upload da nova
            $imagem_url = $this->uploadImagem($_FILES['imagem'] ?? null) ?: $imagem_atual;

            $model = new Produto();
            $sucesso = $model->atualizar($id, [
                'nome' => $nome,
                'preco_custo' => $preco_custo,
                'preco_venda' => $preco_venda,
                'estoque_atual' => $estoque_atual,
                'estoque_minimo' => $estoque_minimo,
                'imagem_url' => $imagem_url
            ]);

            if ($sucesso) {
                $_SESSION['mensagem_sucesso'] = 'Produto atualizado com sucesso!';
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao atualizar o produto.';
            }

            header('Location: /produtos');
            exit;
        }
    }

    // Processa a exclusão (Delete)
    public function deletar(): void {
        session_start();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $model = new Produto();
            if ($model->deletar($id)) {
                $_SESSION['mensagem_sucesso'] = 'Produto removido com sucesso!';
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao remover o produto.';
            }
        }

        header('Location: /produtos');
        exit;
    }

    private function uploadImagem(?array $file): ?string {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                $novoNome = md5(time() . $file['name']) . '.' . $extension;
                $destino = __DIR__ . '/../../public/uploads/' . $novoNome;
                if (move_uploaded_file($file['tmp_name'], $destino)) {
                    return '/uploads/' . $novoNome;
                }
            }
        }
        return null;
    }
}
