CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'usuario') DEFAULT 'usuario',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de usuário admin inicial (Senha: 12345678)
INSERT INTO usuarios (nome, email, senha, perfil) 
VALUES ('Administrador', 'admin@estoque.com', '$2y$10$w3U6m1e9C5A...hash_da_senha...', 'admin');