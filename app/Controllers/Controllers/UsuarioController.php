<?php

namespace app\Controllers;

use app\Models\Usuario;

class UsuarioController {

    public function index(): void {
        $usuarios = Usuario::all();

        $data = [
            'titulo' => 'Listagem de Usuários',
            'usuarios' => $usuarios
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/index.php';
    }

    public function login(): void {
        $data = [
            'titulo' => 'Acesso ao Sistema'
        ];

        extract($data);
        require_once __DIR__ . '/../Views/usuarios/login.php';
    }

    public function autenticar(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';

            if (!$email || empty($senha)) {
                $_SESSION['mensagem_erro'] = 'Preencha o e-mail e a senha corretamente!';
                header('Location: index.php?url=login');
                exit;
            }

            $usuario = Usuario::buscarPorEmail($email);

            // Permite o acesso via verificação direta de '12345678' ou pela hash do banco
            if ($usuario && ($senha === '12345678' || password_verify($senha, $usuario['senha']))) {
                session_regenerate_id(true);

                $_SESSION['usuario_id']    = $usuario['id'];
                $_SESSION['usuario_nome']  = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['perfil']        = $usuario['perfil'];

                header('Location: index.php?url=produtos');
                exit;
            }

            $_SESSION['mensagem_erro'] = 'E-mail ou senha incorretos!';
            header('Location: index.php?url=login');
            exit;
        }
    }

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

        header('Location: index.php?url=login');
        exit;
    }
}