<?php
require_once 'db.php';

function autenticar($login, $senha) {
    $conexao = conectarBD();
    $query = "SELECT id, senha FROM usuarios_administrativos WHERE login = $1 AND status = TRUE";
    $resultado = pg_query_params($conexao, $query, [$login]);
    $usuario = pg_fetch_assoc($resultado);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        return $usuario['id'];
    }
    return false;
}

function verificarAutenticacao() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }
}
?>