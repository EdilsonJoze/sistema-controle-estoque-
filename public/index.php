<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Helpers\Auth;

// Obtém o método HTTP e a URL amigável via GET
$method = $_SERVER['REQUEST_METHOD'];
$url = $_GET['url'] ?? '';

// Normaliza a URL para verificações de segurança
$urlLimpa = trim($url, '/');

// --- VERIFICAÇÃO DE SEGURANÇA E AUTENTICAÇÃO ---
// Permite acesso livre apenas para a tela de login e processamento do formulário
$rotasPublicas = ['login', 'login/autenticar'];

if (!in_array($urlLimpa, $rotasPublicas)) {
    // Exige login ativo para qualquer outra rota
    Auth::check();
}

// Rotas exclusivas para o perfil Administrador
$rotasAdmin = ['produtos/cadastrar', 'produtos/salvar', 'produtos/deletar'];

if (in_array($urlLimpa, $rotasAdmin)) {
    Auth::checkAdmin();
}

// --- REGISTRO DE ROTAS DO SISTEMA ---
$router = new Router();

// Rota Principal / Home
$router->add('GET', '', 'HomeController', 'index');

// Rotas de Autenticação
$router->add('GET', 'login', 'UsuarioController', 'login');
$router->add('POST', 'login/autenticar', 'UsuarioController', 'autenticar');
$router->add('GET', 'logout', 'UsuarioController', 'logout');

// Rotas de Usuários
$router->add('GET', 'usuarios', 'UsuarioController', 'index');

// Rotas de Produtos (Antigo index2.php)
$router->add('GET', 'produtos', 'ProdutoController', 'index');
$router->add('GET', 'produtos/cadastrar', 'ProdutoController', 'criar');
$router->add('POST', 'produtos/salvar', 'ProdutoController', 'salvar');
$router->add('GET', 'produtos/editar', 'ProdutoController', 'editar');
$router->add('POST', 'produtos/atualizar', 'ProdutoController', 'atualizar');
$router->add('POST', 'produtos/deletar', 'ProdutoController', 'deletar');

// Despacha a requisição para o Controller e Método correspondentes
$router->dispatch($method, $url);
