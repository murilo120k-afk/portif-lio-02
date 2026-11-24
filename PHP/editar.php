/*
// Código para editar livros
$id = $_POST["id"];
$autor = $_POST["autor"];
$titulo = $_POST["titulo"];
$ano_publicacao = $_POST["ano_publicacao"];
$adiçao = $_POST["adiçao"];
$quantidade = $_POST["quantidade"];

mysqli_connect("localhost", "root", "root", "KonLivro") or die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
$sql = "INSERT INTO livros (autor, titulo, categoria, ano_publicacao, adiçao, quantidade) VALUES ('$autor', '$titulo', '$categoria', $ano_publicacao, '$adiçao', $quantidade)";
$result = mysqli_query($con,$sql);
*/
<?php

$conexao = new mysqli(
    'localhost',
    'root',
    'root',
    'KonLivro'
);

if ($conexao->connect_error) {
    die('Erro na conexão com o banco de dados.');
}

$conexao->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido.');
}

$id = (int) ($_POST['id'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$quantidade = (int) ($_POST['quantidade'] ?? 0);
$preco = (float) ($_POST['preco'] ?? 0);

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
        preco = ?
    WHERE id = ?
";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    'sssidi',
    $titulo,
    $autor,
    $categoria,
    $quantidade,
    $preco,
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