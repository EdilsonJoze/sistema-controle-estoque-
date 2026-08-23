<?php

namespace App\Core;

class Auth {
    
    // Proteção de sessão ativa
    public static function check(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // Proteção para perfil exclusivo de Admin
    public static function checkAdmin(): void {
        self::check();
        
        if (($_SESSION['perfil'] ?? '') !== 'admin') {
            header('Location: /produtos');
            exit;
        }
    }
}