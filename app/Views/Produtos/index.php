<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produtos Cadastrados</h2>
        <a href="index.php?url=produtos/cadastrar" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <table class="table table-striped table-bordered align-middle bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço Venda</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td style="width: 80px;" class="text-center">
                            <?php if (!empty($p['imagem_url'])): ?>
                                <img src="<?= $p['imagem_url'] ?>" alt="<?= $p['nome'] ?>" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <span class="badge bg-secondary">Sem Foto</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td>R$ <?= number_format($p['preco_venda'] ?? $p['preco'] ?? 0, 2, ',', '.') ?></td>
                        <td><?= $p['estoque_atual'] ?? $p['quantidade'] ?? 0 ?></td>
                        <td>
                            <a href="index.php?url=produtos/editar&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="index.php?url=produtos/deletar" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este produto?');">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum produto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>