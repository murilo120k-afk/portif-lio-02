<?php
// Código para cadastro de livros
require_once "conexao.php"; 
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

$autor = $_POST['autor'] ?? '' ;
$titulo = $_POST['titulo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$ano_publicacao = $_POST['ano_publicacao'] ?? '';
$adiçao = $_POST['adiçao_date'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';

if (empty($autor) || empty($titulo) || empty($categoria) || empty($ano_publicacao) || empty($adiçao) || empty($quantidade)) {
    echo "Preencha todos os campos obrigatórios.";
    exit;
$sql = "INSERT INTO livros (autor, titulo, categoria, ano_publicacao, adiçao, quantidade) VALUES ('$autor', '$titulo', '$categoria', $ano_publicacao, '$adiçao', $quantidade)";
$result = mysqli_query($conexao, $sql);

if ($result) {
    echo "Livro cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar livro: " . mysqli_error($con);
}
?>