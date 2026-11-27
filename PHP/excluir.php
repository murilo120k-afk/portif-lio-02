<?php

require_once "conexao.php";
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

header('Content-Type: application/json; charset=utf-8');

function responder($dados, $status = 200)
{
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responder(
        ['mensagem' => 'Método não permitido.'],
        405
    );
}

$sql = "
    SELECT 
        id,
        titulo,
        autor,
        categoria,
        quantidade,
        adicao,
        ano_publicacao
    FROM livros
    ORDER BY id DESC
";

$consulta = mysqli_query($conexao, $sql);

if (!$consulta) {
    responder(
        [
            'mensagem' => 'Erro ao consultar os livros.',
            'erro' => mysqli_error($conexao)
        ],
        500
    );
}

$livros = mysqli_fetch_all($consulta, MYSQLI_ASSOC);

responder($livros);
