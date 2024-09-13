# PHP Contacts API

Este projeto é uma API RESTful criada em **PHP** puro, que gerencia usuários e seus contatos (e-mail, telefone, WhatsApp, etc). A API permite realizar operações de CRUD (Criar, Ler, Atualizar e Excluir) tanto para os usuários quanto para seus contatos.

## Requisitos

- PHP
- MySQL ou MariaDB
- Composer
- Servidor Apache ou qualquer servidor que suporte PHP
- XAMPP (opcional, para ambiente de desenvolvimento local)

## Instalação

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/seu-usuario/seu-projeto.git
   cd seu-projeto

2. **Instale as dependências via Composer:**

   ```bash
   composer install

3. **Configurar o banco de dados:**

    Crie um banco de dados MySQL e importe o script de criação de tabelas (ajuste o nome do banco e as credenciais no .env):

   ```mysql
    CREATE DATABASE contacts_api;
    USE contacts_api;
    
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );
    
    CREATE TABLE contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        type ENUM('email', 'phone', 'whatsapp') NOT NULL,
        value VARCHAR(255) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
    ```
4. **Copie o arquivo .env.example para .env e ajuste suas credenciais de banco de dados:**

   ```bash
   cp .env.example .env
   ```
    No arquivo .env, edite as informações do banco de dados, como:

   ```env
    DB_HOST=localhost
    DB_NAME=contacts_api
    DB_USER=root
    DB_PASS=sua_senha
    ```
5. **Inicie o servidor:**
   
   Você pode usar o servidor embutido do PHP para rodar a API:

   ```bash
   php -S localhost:8080 -t public
   
6. **Testar a API:**

   Agora você poderá testar a sua api, disponível em: http://localhost:8080
