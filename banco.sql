-- Criação do banco de dados (caso não exista)
CREATE DATABASE IF NOT EXISTS `sistema_estoque` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema_estoque`;

-- --------------------------------------------------------
-- Estrutura da tabela `usuarios`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `perfil` VARCHAR(20) DEFAULT 'usuario',
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção do usuário Administrador (Senha: 12345678)
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `perfil`) VALUES
('Administrador', 'admin@estoque.com', '$2y$10$e8.I44A4S7x5qE82Y/oY.O/X62G4VlJ7/P0Z6G.I6aP20CjCgO9j2', 'admin');

-- --------------------------------------------------------
-- Estrutura da tabela `produtos`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `preco_custo` DECIMAL(10, 2) DEFAULT 0.00,
    `preco_venda` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `estoque_atual` INT NOT NULL DEFAULT 0,
    `estoque_minimo` INT DEFAULT 0,
    `imagem_url` VARCHAR(255) DEFAULT NULL,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dados de teste para a tabela `produtos`
INSERT INTO `produtos` (`nome`, `preco_custo`, `preco_venda`, `estoque_atual`, `estoque_minimo`) VALUES
('Teclado Mecânico', 120.00, 249.90, 25, 3),
('Mouse Sem Fio', 40.00, 89.90, 50, 5),
('Notebook Dell', 2500.00, 3500.00, 10, 2);