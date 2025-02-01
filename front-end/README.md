# README

## Mini Aplicação em Vue.js usando Typescript

Essa é uma aplicação desenvolvida com Vue 3 utilizando Vuex para gerenciamento de estado. Ela consiste em funcionalidades como:

* Cadastro de usuário
* Login do usuário
* Logout do usuário
* Exibição do perfil do usuário após login

## Principais Tecnologias Utilizadas

* Vue 3: Framework JavaScript progressivo para construir interfaces de usuário.
* Vuex: Biblioteca de gerenciamento de estado centralizado.
* Vue Router: Para navegação entre rotas da aplicação.
* TypeScript: Linguagem para tipagem estática e segurança de código.

## Requisitos do Sistema

Certifique-se de que os seguintes requisitos estejam instalados em sua máquina:

* Node.js >= 16.x
* NPM ou Yarn (para gerenciar dependências do frontend)

## Instalação

1. Clonar o Repositório

``` bash
  git clone git@github.com:Joaovitor12j/symfony-api.git
```

2. Configurar as Dependências do Frontend
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

### Rotas da Aplicação

1. Cadastro de Usuário  

    `/register`


2. Login do Usuário

    `/login`

3. Dados do Usuário Logado

    `/user`

4. Tela de boas vindas após o cadastro

    `/registered`

5. Logout

    `/logout`


## Estrutura do Projeto

A estrutura de pastas foi organizada para manter o projeto modular, escalável e fácil de manter

src/  
├── api/  
├── components/  
├── models/  
├── pages/  
├── store/  
├── styles/  
├── App.vue  
├── main.ts  
├── router.ts  

### src/api/

Essa pasta contém arquivos relacionados à comunicação com APIs externas. Aqui estão as chamadas HTTP encapsuladas em funções para reutilização em diferentes partes da aplicação.

* **Exemplo**: index.ts

**Por que?**
Manter as chamadas API em um só lugar facilita a manutenção e centraliza as configurações (como URLs base ou tokens de autenticação).

### src/components/

Componentes reutilizáveis da aplicação. Exemplos incluem botões, formulários, ou outros elementos menores que podem ser usados em diferentes partes do sistema.

* **Exemplo**: RegisterForm.vue, LoginForm.vue

**Por que?**
Isolar elementos reutilizáveis permite que o código seja mais modular e reduz a duplicidade de código.

### src/models/

Define os modelos de dados e interfaces TypeScript usadas no projeto.

* **Exemplo**: User.ts (modelo para o usuário), Errors.ts (modelo para erros)

**Por que?**
Ao usar TypeScript, garantir que os dados tenham uma estrutura bem definida reduz erros e melhora a segurança do código.

### src/pages/

Armazena as páginas da aplicação que estão diretamente relacionadas às rotas.

* **Exemplo**: Login.vue, UserProfile.vue

**Por que?**
Manter páginas separadas permite uma estrutura mais clara e facilita a navegação entre diferentes áreas da aplicação.

### src/store/

Contém a configuração do Vuex, incluindo os estados, mutações e ações globais da aplicação.

* **Exemplo**: index.ts

**Por que?**
Manter um gerenciamento de estado centralizado é essencial para aplicações que compartilham informações entre diferentes componentes e páginas.

### src/App.vue

O componente raiz da aplicação. É aqui que os outros componentes e páginas são integrados.

**Por que?**
O App.vue é o ponto de entrada para a interface do usuário.

### src/main.ts

Arquivo principal que inicializa a aplicação Vue, configurando o Vue Router e o Vuex Store.

**Por que?**
É o ponto de inicialização da aplicação, essencial para registrar dependências globais e montar o app.

### src/router.ts

Define as rotas da aplicação, mapeando URLs para páginas/componentes Vue.

**Por que?**
Ter um arquivo dedicado à configuração de rotas facilita a manutenção e expansão da navegação do sistema.

## Decisões de arquitetura

### Rotas
No arquivo de rotas, foi aplicado na configuração dos imports o Lazy Loading, para melhorar o desempenho, reduzindo o tempo de carregamento da página.

Foi usando constantes com os caminhos das rotas e dos endpoints da API, reduzindo o erro e facilitando alterações.

### Componentização

Os formulários foram separados em componentes, melhorando a legibilidade, reutilização e manutenção.

## Considerações Finais

A estrutura de pastas e o uso do Vuex foram planejados para:

* **Modularidade**: Facilitar a manutenção e escalabilidade do código.
* **Segurança**: Garantir o uso seguro de dados sensíveis.
* **Reutilização**: Permitir reaproveitamento de componentes e lógica em diferentes partes da aplicação.

Com essa organização, a aplicação está preparada para crescer sem comprometer a clareza ou a performance.