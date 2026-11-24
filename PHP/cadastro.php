<?php
// Código para cadastro de livros

$autor = $_POST["autor"];
$titulo = $_POST["titulo"];
$categoria = $_POST["categoria"];
$ano_publicacao = $_POST["ano_publicacao"];
$adiçao = $_POST["adiçao_date"];
$quantidade = $_POST["quantidade"];

mysqli_connect("localhost", "root", "root", "KonLivro") or die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
$sql = "INSERT INTO livros (autor, titulo, categoria, ano_publicacao, adiçao, quantidade) VALUES ('$autor', '$titulo', '$categoria', $ano_publicacao, '$adiçao', $quantidade)";

?>