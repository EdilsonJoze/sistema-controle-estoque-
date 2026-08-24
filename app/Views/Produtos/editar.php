<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>

    <form action="produtos/atualizar" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
        <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($produto['imagem_url'] ?? '') ?>">

        <p>
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </p>
        <p>
            <label>Preço Custo:</label><br>
            <input type="number" step="0.01" name="preco_custo" value="<?= $produto['preco_custo'] ?>" required>
        </p>
        <p>
            <label>Preço Venda:</label><br>
            <input type="number" step="0.01" name="preco_venda" value="<?= $produto['preco_venda'] ?>" required>
        </p>
        <p>
            <label>Estoque Atual:</label><br>
            <input type="number" name="estoque_atual" value="<?= $produto['estoque_atual'] ?>" required>
        </p>
        <p>
            <label>Estoque Mínimo:</label><br>
            <input type="number" name="estoque_minimo" value="<?= $produto['estoque_minimo'] ?>" required>
        </p>
        <p>
            <label>Alterar Foto (Opcional):</label><br>
            <input type="file" name="imagem" accept="image/*">
        </p>
        <button type="submit">Salvar Alterações</button>
        <a href="produtos">Cancelar</a>
    </form>
</body>
</html>