<?php

namespace App\Controllers;

class HomeController {
    public function index(): void {
        $data = [
            'titulo' => 'Página Inicial',
            'mensagem' => 'Bem-vindo à aplicação com estrutura MVC e rotas funcionais!'
        ];

        extract($data);
        require_once __DIR__ . '/../Views/home.php';
    }
}