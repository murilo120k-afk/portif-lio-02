
// Código para listar livros
/*$id =
$autor =
$titulo =
$ano_publicacao =
$adiçao  =
$quantidade =
*/
<?php
$conexao = new mysqli(
    'localhost',
    'root',
    'root',
    'KonLivro'
) or die(mysqli_error($conexao));
$conexao->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responder(['mensagem' => 'Método não permitido.'], 405);
}

$consulta = $conexao->query(
    'SELECT id, titulo, autor, categoria, quantidade, adiçao, ano_publicacao
     FROM livros ORDER BY id DESC'
);

responder($consulta->fetchAll());
?>