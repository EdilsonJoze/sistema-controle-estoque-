<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'Listagem de Usuários') ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($titulo ?? 'Listagem de Usuários') ?></h1>

    <ul>
        <?php foreach ($usuarios as $usuario): ?>
            <li>
                <?= htmlspecialchars(is_array($usuario) ? $usuario['nome'] : $usuario->getNome()) ?> - 
                <?= htmlspecialchars(is_array($usuario) ? $usuario['email'] : $usuario->getEmail()) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="./">Voltar para a Home</a>
</body>
</html>