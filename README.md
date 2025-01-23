# README

## Documentação Completa 
Foi criado uma documentação mais detalhada para API Symfoy e para a aplicação Front-end

**Back-end**  
[API Symfony](/back-end/README.md)

**Front-end**  
[Aplicação VUW](/front-end/README.md)

## API Symfony com Integração Vue.js

Este repositório contém um projeto construído com o framework Symfony para o backend e Vue.js no frontend. O objetivo é fornecer uma API RESTful para
manipulação de usuários com funcionalidades como cadastro, login e validação de sessão.

## Requisitos do Sistema

Certifique-se de que os seguintes requisitos estejam instalados em sua máquina:

* PHP >= 8.1
* Composer
* MySQL ou MariaDB
* Symfony CLI (opcional, mas recomendado)
* Node.js >= 16.x
* NPM ou Yarn (para gerenciar dependências do frontend)

## Instalação

1. Clonar o Repositório

    ``` bash
      git clone git@github.com:Joaovitor12j/desafio-merchion.git
    ```

2. Configurar as Dependências do Backend
    * Instale as dependências do Symfony:
   ``` bash
    composer install
    ```
    * Copie o arquivo de exemplo .env.example para configurar as variáveis de ambiente:
    ``` bash
    cp .env.example .env
    ```

    * Edite o arquivo .env para configurar a conexão com o banco de dados:
        * DATABASE_URL="mysql://<usuario>:<senha>@127.0.0.1:3306/<nome-do-banco>"
        * APP_SECRET="sua-chave-secreta"

    * Execute as migrações para criar a estrutura do banco de dados:
   ``` bash
   php bin/console doctrine:migrations:migrate    
   ```

3. Iniciar o Servidor Symfony

    * Para iniciar o servidor de desenvolvimento do Symfony:

      Se o comando symfony não for encontrado, será necessário instalar o synfony CLI no seu SO.
      Faça a instalação seguindo a documentação do [Symfony CLI](https://symfony.com/download)
   ``` bash
   symfony server:start
   ```

   A API estará disponível em: http://127.0.0.1:8000

   A porta pode ser diferente dependendo da configuração do seu sistema.

4. Configurar as Dependências do Frontend
    * Navegue até o diretório do frontend
    ``` bash
      cd front-end
    ```
    * Instale as dependências do Vue.js:
         ``` bash
          npm install
         ```
      ou
         ``` bash
          yarn install
         ```
    * Inicie o servidor de desenvolvimento:
        ``` bash
          npm run dev
         ```
      ou
         ``` bash
          yarn dev
         ```

   O servidor será iniciado em: http://localhost:3000/

   A porta pode ser diferente dependendo da configuração do seu sistema.


## Endpoints da API
Foi criada uma Collection.JSON do Postman com todos os Endpoints da API,
pode ser baixado o arquivo e importado no Postman  

[Collection](/API%20-%20MERCHION.postman_collection.json)

**Base URL**

Todas as requisições devem ser feitas para a URL base: http://127.0.0.1:8000

1. Cadastro de Usuário

   ##### Endpoint: `POST /register`
   **Request**  
   {

         "name": "Seu Nome",
         "email": "seu.email@example.com",
         "password": "sua_senha"
   }
   \
   **Response**

   201 — HTTP CREATED  
   {

         "name": "Seu Nome",
         "email": "seu.email@example.com" 
   }

2.  Login do Usuário

    ##### Endpoint: `POST /login`
    **Request**  
    {

            "email": "seu.email@example.com",
            "password": "sua_senha"
    }  
    \
    **Response**

    200 — HTTP_OK  
    {

         "name": "Seu Nome",
         "email": "seu.email@example.com" 
    }

3. Dados do Usuário Logado
   ##### Endpoint: `GET /user`
   **Headers**  
   Cookie de sessão gerado no login.

   **Response**

   200 — HTTP_OK  
   {

         "name": "Seu Nome",
         "email": "seu.email@example.com" 
   }

   401 — Unauthorized (caso a sessão não seja encontrada):

   {

         "mensagem": "Usuário não autenticado."
   }

4. Logout
   ##### Endpoint: `POST /logout`

   **Response**

   200 — HTTP_OK  
   Resposta vazia.

### Licença

Este projeto está licenciado sob MIT License
