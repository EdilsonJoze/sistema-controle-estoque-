<?php

namespace App\Controllers;

use App\Models\Usuario;

class UsuarioController {

    // Método original mantido para listagem de usuários
    public function index(): void {
        $usuarios = Usuario::all();

        $data = [
            'titulo' => 'Listagem de Usuários',
            'usuarios' => $usuarios
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/index.php';
    }

    // Exibe o formulário de login
    public function login(): void {
        $data = [
            'titulo' => 'Acesso ao Sistema'
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/login.html';
    }

    // Processa a autenticação com validação de senha (password_verify) e controle de sessão
    public function autenticar(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';

            if (!$email || empty($senha)) {
                $_SESSION['mensagem_erro'] = 'Preencha o e-mail e a senha corretamente!';
                header('Location: /login');
                exit;
            }

            // Utiliza o método buscarPorEmail do Model
            $usuario = Usuario::buscarPorEmail($email);

            // Valida se o usuário existe e verifica o hash da senha
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Regenera o ID de sessão para segurança
                session_regenerate_id(true);

                $_SESSION['usuario_id']    = $usuario['id'];
                $_SESSION['usuario_nome']  = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['perfil']        = $usuario['perfil'];

                header('Location: /produtos');
                exit;
            }

            $_SESSION['mensagem_erro'] = 'E-mail ou senha incorretos!';
            header('Location: /login');
            exit;
        }
    }

    // Destrói a sessão e encerra o acesso
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $_SESSION = [];
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header('Location: /login');
        exit;
    }
}
