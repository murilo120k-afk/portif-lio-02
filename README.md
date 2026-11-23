##Sistema de Gestão de Acervo
    Este projeto consiste em um sistema web para gerenciar o acervo de uma livraria. A aplicação permite cadastrar, editar, listar e pesquisar livros de forma simples e organizada.

##Funcionalidades
    Cadastro de novos livros;
    Alteração dos dados dos livros;
    Listagem dos livros cadastrados;
    Pesquisa de livros pelo título;
    Dashboard com informações do acervo;
    Interface responsiva para diferentes dispositivos.

##Tecnologias utilizadas
    -HTML5;
    -CSS3;
    -JavaScript;
    -PHP;
    -MySQL ou PostgreSQL;
##PDO para conexão segura com o banco de dados.
##Segurança
O sistema utiliza boas práticas de desenvolvimento, como validação de dados e consultas preparadas com PDO, ajudando a prevenir ataques de SQL Injection.

##estrutura
Portifolio-02/
│
├── index.html              # Página inicial do sistema
├── cadastrar.html          # Formulário de cadastro
├── editar.html             # Tela de edição
├── listar.html             # Lista de livros
│
├── css/
│   └── style.css           # Estilos das páginas
│
├── js/
│   └── script.js           # Validações e interações
│
├── php/
│   ├── conexao.php         # Conexão com o banco
│   ├── cadastrar.php       # Cadastro de livros
│   ├── listar.php          # Consulta dos livros
│   ├── editar.php          # Alteração dos livros
│   └── excluir.php         # Exclusão dos livros
│
└── database/
    └── banco.sql           # Estrutura do banco de dados


##Objetivo
O objetivo do projeto é facilitar o controle dos livros de uma livraria, tornando o cadastro, a consulta e a atualização das informações mais rápidos, seguros e organizados.