$router->add('GET', 'produtos', 'ProdutoController', 'index');
$router->add('GET', 'produtos/cadastrar', 'ProdutoController', 'criar');
$router->add('POST', 'produtos/salvar', 'ProdutoController', 'salvar');
$router->add('GET', 'produtos/editar', 'ProdutoController', 'editar');
$router->add('POST', 'produtos/atualizar', 'ProdutoController', 'atualizar');
$router->add('POST', 'produtos/deletar', 'ProdutoController', 'deletar');
