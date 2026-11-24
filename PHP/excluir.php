<?php

$conexao = new mysqli(
    'localhost',
    'root',
    'root',
    'KonLivro'
);

if ($conexao->connect_error) {
    die('Erro ao conectar ao banco de dados.');
}

$conexao->set_charset('utf8mb4');

// Recebe o ID enviado por POST
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    die('ID do livro inválido.');
}

// Consulta preparada para evitar SQL Injection
$sql = 'DELETE FROM livros WHERE id = ?';

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die('Erro ao preparar a exclusão.');
}

$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo '
            <h1>Livro excluído com sucesso!</h1>
            <p>O registro foi removido do banco de dados.</p>
            <a href="../lista.html">Voltar para a lista</a>
        ';
    } else {
        echo '
            <h1>Livro não encontrado</h1>
            <p>Nenhum livro possui esse ID.</p>
            <a href="../lista.html">Voltar para a lista</a>
        ';
    }
} else {
    echo 'Erro ao excluir o livro.';
}

$stmt->close();
$conexao->close();
