$router->add('GET', 'produtos', 'ProdutoController', 'index');
$router->add('GET', 'produtos/cadastrar', 'ProdutoController', 'criar');
$router->add('POST', 'produtos/salvar', 'ProdutoController', 'salvar');