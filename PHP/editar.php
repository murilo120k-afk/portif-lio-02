<?php

require_once "conexao.php";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

$conexao->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Método inválido.");
}

$id = (int) ($_POST["id"] ?? 0);
$titulo = trim($_POST["titulo"] ?? "");
$autor = trim($_POST["autor"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");
$quantidade = (int) ($_POST["quantidade"] ?? 0);

if (
    $id <= 0 ||
    $titulo === "" ||
    $autor === "" ||
    $categoria === "" ||
    $quantidade <= 0
) {
    die("Preencha todos os campos obrigatórios com valores válidos.");
}

$sql = "
    UPDATE livros
    SET
        titulo = ?,
        autor = ?,
        categoria = ?,
        quantidade = ?
    WHERE id = ?
";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conexao->error);
}

$stmt->bind_param(
    "sssii",
    $titulo,
    $autor,
    $categoria,
    $quantidade,
    $id
);

if ($stmt->execute()) {
    echo "
        <h1>Livro atualizado com sucesso!</h1>
        <a href=\"../lista.html\">Voltar para a lista</a>
    ";
} else {
    echo "Erro ao atualizar o livro: " . $stmt->error;
}

$stmt->close();
$conexao->close();

?>
