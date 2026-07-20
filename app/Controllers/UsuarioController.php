<?php

namespace App\Controllers;

class UsuarioController {
    public function index(): void {
        $data = [
            'titulo' => 'Listagem de Usuários'
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/index.php';
    }
}