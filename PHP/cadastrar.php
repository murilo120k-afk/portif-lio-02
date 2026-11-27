<?php

require_once "conexao.php";

$conexao = mysqli_connect(
    $servidor,
    $usuario,
    $senha,
    $banco
);

if (!$conexao) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

$conexao->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Método não permitido.");
}

$autor = trim($_POST["autor"] ?? "");
$titulo = trim($_POST["titulo"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");
$quantidade = (int) ($_POST["quantidade"] ?? 0);

if (
    $autor === "" ||
    $titulo === "" ||
    $categoria === "" ||
    $quantidade <= 0
) {
    die("Preencha todos os campos obrigatórios com valores válidos.");
}

$sql = "
    INSERT INTO livros (
        autor,
        titulo,
        categoria,
        quantidade
    ) VALUES (?, ?, ?, ?)
";

$stmt = mysqli_prepare($conexao, $sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . mysqli_error($conexao));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $autor,
    $titulo,
    $categoria,
    $quantidade
);

if (mysqli_stmt_execute($stmt)) {
    $mensagem = urlencode("Livro cadastrado com sucesso!");

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

    header("Location: ../HTML/index.html?mensagem=$mensagem");
    exit;
}

$erro = urlencode(
    "Erro ao cadastrar livro: " . mysqli_stmt_error($stmt)
);

mysqli_stmt_close($stmt);
mysqli_close($conexao);

header("Location: ../HTML/cadastrar.html?erro=$erro");
exit;
?>

