# TaskSync - To Do List & Gerenciamento de Tarefas

## Sobre o Projeto
TaskSync é uma aplicação simples de gerenciamento de tarefas com funcionalidades básicas de CRUD, baseada na metodologia Kanban.
Este projeto foi desenvolvido utilizando PHP, MySQL, HTML, CSS e Vanilla JavaScript.

## Pré-requisitos
Para rodar este projeto localmente, você precisará de:
- Servidor Local (ex: **XAMPP**, **WAMP** ou **Laragon**) com Apache e MySQL habilitados.

## Instalação e Configuração

1. **Clone ou extraia** este repositório na pasta do seu servidor web (`htdocs` no XAMPP ou `www` no WAMP).
2. Abra seu gerenciador de banco de dados (ex: `phpMyAdmin`).
3. Crie um banco de dados chamado `tasksync` (opcional, o script já faz isso se não existir).
4. Importe o arquivo `database/schema.sql` fornecido neste repositório.
5. Inicie os servidores **Apache** e **MySQL** no seu XAMPP/WAMP.

> **Nota sobre o Banco de Dados:** A configuração de conexão com o banco no arquivo `config.php` utiliza por padrão o usuário `root` e senha vazia `''` (padrão XAMPP). Caso seu ambiente local possua uma senha de banco, por favor, atualize o arquivo `config.php`.

## Como Testar o Sistema

Conforme as Regras de Negócio do desafio, **não há necessidade de login e senha no sistema**, portanto, não há um usuário admin para acessar a aplicação. Todo o fluxo é aberto para facilitar os testes.

1. Acesse o projeto no navegador: `http://localhost/Senai kanban php/`
2. **Cadastro de Usuário:** Vá até a aba "Cadastrar Usuário" e crie um usuário para ser o responsável pelas tarefas.
3. **Cadastro de Tarefa:** Vá até a aba "Nova Tarefa", selecione o usuário criado, e preencha os dados (Descrição, Setor, Prioridade). Ela iniciará automaticamente na coluna "A Fazer".
4. **Gerenciamento (Quadro Kanban):** Na aba "Kanban Board", você visualizará o quadro com as 3 colunas:
   - **Rosa** (A Fazer)
   - **Amarelo** (Fazendo)
   - **Verde** (Concluído)
   
   Você pode **Editar** (abre um modal para editar os dados), **Excluir** a tarefa, ou movê-la entre os status clicando nas setas (⬅️ / ➡️) presentes no rodapé do card da tarefa.

## Entregas Atendidas

1. **DER:** Localizado em `docs/der.md` (Formato Mermaid)
2. **Banco de Dados:** Localizado em `database/schema.sql`
3. **Caso de Uso:** Localizado em `docs/caso_de_uso.md` (Formato Mermaid)
4. **Tela de Cadastro de Usuário:** `cadastrar_usuario.php`
5. **Tela de Cadastro de Tarefas:** `cadastrar_tarefa.php`
6. **Tela de Gerenciamento (Kanban):** `index.php`

## Tecnologias e Bibliotecas
- O projeto usa apenas bibliotecas nativas (PDO para PHP).
- Nenhuma dependência do NPM ou Composer é necessária.
- A fonte **Inter** é carregada via Google Fonts.
