<?php

namespace App\Controllers;

use App\Models\Usuario;

class UsuarioController {
    public function index(): void {
        // Busca os dados da camada Model
        $usuarios = Usuario::all();

        $data = [
            'titulo' => 'Listagem de Usuários',
            'usuarios' => $usuarios
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/index.php';
    }
}
