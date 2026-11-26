<?php

require_once "conexao.php"; 
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

$conexao->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido.');
}

$id = (int) ($_POST['id'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$quantidade = (int) ($_POST['quantidade'] ?? 0);

if (empty($autor) || empty($titulo) || empty($categoria) || empty($ano_publicacao) || empty($adiçao) || empty($quantidade)) {
    echo "Preencha todos os campos obrigatórios.";
    exit;

if ($id <= 0 || $titulo === '' || $autor === '') {
    die('Dados inválidos.');
}

$sql = "
    UPDATE livros
    SET
        titulo = ?,
        autor = ?,
        categoria = ?,
        quantidade = ?,
    WHERE id = ?
";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    'sssidi',
    $titulo,
    $autor,
    $categoria,
    $quantidade,
    $id
);

if ($stmt->execute()) {
    echo '
        <h1>Livro atualizado com sucesso!</h1>
        <a href="../lista.html">Voltar para a lista</a>
    ';
} else {
    echo 'Erro ao atualizar o livro.';
}

$stmt->close();
$conexao->close();
?>