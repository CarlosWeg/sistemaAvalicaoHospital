<?php
require_once 'db.php';

function obterPerguntas() {
    $conexao = conectarBD();
    $resultado = pg_query($conexao, "SELECT id, texto FROM perguntas WHERE status = TRUE");
    return pg_fetch_all($resultado);
}

function cadastrarPergunta($texto) {
    $conexao = conectarBD();
    $query = "INSERT INTO perguntas (texto) VALUES ($1)";
    pg_query_params($conexao, $query, [$texto]);
}
?>