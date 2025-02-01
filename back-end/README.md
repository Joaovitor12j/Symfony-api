# README

## API Symfony com Integração Vue.js

Este repositório contém um projeto construído com o framework Symfony para o backend e Vue.js no frontend. O objetivo é fornecer uma API RESTful para
manipulação de usuários com funcionalidades como cadastro, login e validação de sessão.

## Requisitos do Sistema

Certifique-se de que os seguintes requisitos estejam instalados em sua máquina:

* PHP >= 8.1
* Composer
* MySQL ou MariaDB
* Symfony CLI (opcional, mas recomendado)

## Instalação

1. Clonar o Repositório

``` bash
  git clone git@github.com:Joaovitor12j/symfony-api.git
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

## Endpoints da API
   Foi criada uma Collection.JSON do Postman com todos os Endpoints da API, 
   pode ser baixado o arquivo e importado no Postman

Base URL

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

## Estrutura do Projeto

* /src/Controller: Controladores responsáveis pelas ações da API.  
* /src/Entity: Entidades do Doctrine, como o modelo User.  
* /src/Repository: Repositórios para acesso aos dados do banco.  
* /src/Validators: Validações personalizadas para tratamento de erros no cadastro e login, como UserValidation.  
* /src/EventSubscriber: Subscriber para eventos do kernel, para o tratamento de exceções.

### Decisões de arquitetura

#### CORS:  
Para realizar chamadas de API de outros domínios sem enfrentar problemas de segurança, é essencial uma política de segurança que permita que recursos
restritos em uma página da web sejam solicitados a partir de outro domínio fora do domínio ao qual o recurso pertence.

Essa política de segurança é o CORS (Cross-Origin Resource Sharing).
Há várias maneiras de adicionar recursos de tratamento de solicitações CORS a um aplicativo Symfony, sendo a solução mais rápida e flexível o
[NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle).

Após a instalação o arquivo é configurado no `config/packages/nelmio_cors.yaml`

Você pode ajustar a configuração conforme suas necessidades, definindo quais origens, cabeçalhos e métodos HTTP são permitidos.

#### Tratamento de Erros:

Foi criada a classe `UserValidation` para ser responsável apenas pela validaçaõ de regras relacionadas ao usuário, mantendo a lógica de negócio 
isolada.

Foi criada a exception `HandleUserException` para tratar erros específicos do domínio.

Implementado um Event Listeners `ExceptionSubscriber`, centralizando o tratamento de exceções e disparar os erros personalizados da 
`HandleUserException` enquanto processa a solicitação HTTP.


### Licença

Este projeto está licenciado sob MIT License
