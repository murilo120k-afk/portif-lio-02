<?php

require_once "conexao.php";

header("Content-Type: application/json; charset=utf-8");

$conexao = mysqli_connect(
    $servidor,
    $usuario,
    $senha,
    $banco
);

if (!$conexao) {
    http_response_code(500);

    echo json_encode([
        "mensagem" => "Erro ao conectar ao banco de dados."
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$conexao->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);

    echo json_encode([
        "mensagem" => "Método não permitido."
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$sql = "
    SELECT
        id,
        titulo,
        autor,
        categoria,
        quantidade,
    FROM livros
    ORDER BY id DESC
";

$consulta = $conexao->query($sql);

if (!$consulta) {
    http_response_code(500);

    echo json_encode([
        "mensagem" => "Erro ao consultar os livros.",
        "erro" => $conexao->error
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$livros = $consulta->fetch_all(MYSQLI_ASSOC);

echo json_encode(
    $livros,
    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);

$consulta->free();
$conexao->close();
