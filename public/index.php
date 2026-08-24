<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Core\Router;
use app\Helpers\Auth;

// Pega o método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Captura a URL tratando a pasta base dinamicamente
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, $scriptName) === 0) {
    $uri = substr($uri, strlen($scriptName));
}

$url = $_GET['url'] ?? $uri;
$urlLimpa = trim($url, '/');

// --- VERIFICAÇÃO DE SEGURANÇA E AUTENTICAÇÃO ---
// Rotas públicas que não exigem login
$rotasPublicas = ['login', 'login/autenticar'];

if (!in_array($urlLimpa, $rotasPublicas)) {
    // Exige login para rotas privadas
    Auth::check();
}

// Rotas exclusivas do perfil Administrador
$rotasAdmin = ['produtos/cadastrar', 'produtos/salvar', 'produtos/deletar'];

if (in_array($urlLimpa, $rotasAdmin)) {
    Auth::checkAdmin();
}

// --- REGISTRO DE ROTAS ---
$router = new Router();

// Rota Principal / Home
$router->add('GET', '', 'HomeController', 'index');

// Rotas de Autenticação
$router->add('GET', 'login', 'UsuarioController', 'login');
$router->add('POST', 'login/autenticar', 'UsuarioController', 'autenticar');
$router->add('GET', 'logout', 'UsuarioController', 'logout');

// Rotas de Usuários
$router->add('GET', 'usuarios', 'UsuarioController', 'index');

// Rotas de Produtos
$router->add('GET', 'produtos', 'ProdutoController', 'index');
$router->add('GET', 'produtos/cadastrar', 'ProdutoController', 'criar');
$router->add('POST', 'produtos/salvar', 'ProdutoController', 'salvar');
$router->add('GET', 'produtos/editar', 'ProdutoController', 'editar');
$router->add('POST', 'produtos/atualizar', 'ProdutoController', 'atualizar');
$router->add('POST', 'produtos/deletar', 'ProdutoController', 'deletar');

// Executa o roteamento
$router->dispatch($method, $urlLimpa);