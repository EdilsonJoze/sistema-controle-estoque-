# Sistema de Controle de Estoque

Sistema em PHP orientado a objetos desenvolvido com arquitetura MVC para gerenciamento de produtos e usuários.

## 🚀 Tecnologias Utilizadas
* **PHP** (8.0+)
* **MySQL / MariaDB** (via PDO)
* **Bootstrap 5** (Interface)
* **Apache** (XAMPP/WAMP)

---

## 🛠️ Instruções de Instalação e Execução

### 1. Clonar ou Baixar o Projeto
Coloque a pasta do projeto dentro do diretório do seu servidor local:
* **XAMPP:** `C:\xampp\htdocs\sistema-controle-estoque--main`

### 2. Configurar o Banco de Dados
1. Inicie os módulos **Apache** e **MySQL** no XAMPP.
2. Acesse o **phpMyAdmin**: `http://localhost/phpmyadmin/`.
3. Vá na aba **Importar** e selecione o arquivo `banco.sql` localizado na raiz do projeto.
4. Clique em **Executar** para criar o banco `sistema_estoque` e popular os dados iniciais.

### 3. Configurar Conexão (Opcional)
Se as credenciais do seu MySQL forem diferentes do padrão XAMPP (`host: 127.0.0.1`, `user: root`, `pass: ""`), ajuste o arquivo `config/Database.php`.

---

## 🔑 Credenciais de Acesso Padrão

* **URL de Acesso:** `http://localhost/sistema-controle-estoque--main/public/index.php?url=login`
* **E-mail:** `admin@estoque.com`
* **Senha:** `12345678`
