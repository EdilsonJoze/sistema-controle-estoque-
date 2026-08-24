<?php

spl_autoload_register(function ($class) {
    // Converte namespace em caminho de arquivo (ex: Config\Database -> config/Database.php)
    $caminhoRelativo = str_replace('\\', '/', $class) . '.php';
    
    $locaisPossiveis = [
        __DIR__ . '/../' . $caminhoRelativo,
        __DIR__ . '/../' . lcfirst($caminhoRelativo),
        __DIR__ . '/../app/' . str_replace('App/', '', $caminhoRelativo),
        __DIR__ . '/../config/' . str_replace('Config/', '', $caminhoRelativo)
    ];

    foreach ($locaisPossiveis as $arquivo) {
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});