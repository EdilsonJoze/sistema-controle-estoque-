<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'Página Inicial') ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($titulo ?? 'Página Inicial') ?></h1>
    <p><?= htmlspecialchars($mensagem ?? '') ?></p>
    <a href="usuarios">Ver Usuários</a>
</body>
</html>