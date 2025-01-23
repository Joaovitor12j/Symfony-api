# README

## API Symfony com Integração Vue.js

Este repositório contém um projeto construído com o framework Symfony para o backend e Vue.js no frontend. O objetivo é fornecer uma API RESTful para
manipulação de usuários com funcionalidades como cadastro, login e validação de sessão.

### Requisitos do Sistema

Certifique-se de que os seguintes requisitos estejam instalados em sua máquina:

PHP >= 8.1

Composer

MySQL ou MariaDB

Symfony CLI (opcional, mas recomendado)

### Instruções de Configuração

1. Clonar o Repositório

``` bash
  git clone git@github.com:Joaovitor12j/desafio-merchion.git
```

2. Configurar as Dependências do Backend
   1. Instale as dependências do Symfony:
   ``` bash
    composer install
    ```
   2. Copie o arquivo de exemplo .env.example para configurar as variáveis de ambiente:
    ``` bash
    cp .env.example .env
    ```

   3. Edite o arquivo .env para configurar a conexão com o banco de dados:
      * DATABASE_URL="mysql://<usuario>:<senha>@127.0.0.1:3306/<nome-do-banco>"
      * APP_SECRET="sua-chave-secreta"

   4. Execute as migrações para criar a estrutura do banco de dados:
   ``` bash
   php bin/console doctrine:migrations:migrate    
   ```
3. Iniciar o Servidor Symfony 

   Para iniciar o servidor de desenvolvimento do Symfony:
   ``` bash
   symfony server:start
   ```