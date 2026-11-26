/*<?php
require_once "conexao.php"; 
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
$conexao->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    res (['mensagem' => 'Método não permitido.'], 405);
}

$consulta = $conexao->query(
    'SELECT id, titulo, autor, categoria, quantidade, adiçao, ano_publicacao
     FROM livros ORDER BY id DESC'
);

responder ($consulta->fetchAll());
?>*/