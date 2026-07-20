<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Definição das rotas da aplicação
$router->add('GET', '', 'HomeController', 'index');
$router->add('GET', 'usuarios', 'UsuarioController', 'index');

// Processa a requisição
$url = $_GET['url'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $url);
