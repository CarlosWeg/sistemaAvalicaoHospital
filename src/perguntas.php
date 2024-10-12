<?php
require_once 'db.php';

function obterPerguntas() {
    $conexao = conectarBD();
    $query = "SELECT id, texto FROM perguntas WHERE status = TRUE ORDER BY ORDEM ASC";
    $resultado = pg_query($conexao, $query);
    return pg_fetch_all($resultado);
}

// Função para cadastrar nova pergunta
if (isset($_POST['cadastrar_pergunta'])) {
    $texto = sanitizarEntrada($_POST['texto_pergunta']);
    if ($texto) {
        $conexao = conectarBD();
        $query = "INSERT INTO perguntas (texto) VALUES ($1)";
        pg_query_params($conexao, $query, [$texto]);
        pg_close($conexao);
    }
    header('Location: ../public/admin.php');
    exit();
}

// Função para remover pergunta
if (isset($_GET['remover'])) {
    $id = (int)$_GET['remover'];
    $conexao = conectarBD();
    $query = "UPDATE perguntas SET status = FALSE WHERE id = $1";
    pg_query_params($conexao, $query, [$id]);
    pg_close($conexao);
    header('Location: ../public/admin.php');
    exit();
}

// Função para editar pergunta (opcional)
if (isset($_POST['editar_pergunta'])) {
    $id = (int)$_POST['id_pergunta'];
    $texto = sanitizarEntrada($_POST['texto_pergunta']);
    if ($id && $texto) {
        $conexao = conectarBD();
        $query = "UPDATE perguntas SET texto = $1 WHERE id = $2";
        pg_query_params($conexao, $query, [$texto, $id]);
        pg_close($conexao);
    }
    header('Location: ../public/admin.php');
    exit();
}
?>