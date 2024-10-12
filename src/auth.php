<?php
session_start();
require_once 'db.php';
require_once 'funcoes.php';

// Função para verificar se o usuário está autenticado
function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: ../public/login.php');
        exit();
    }
}

// Função para processar login
function login($login, $senha) {
    $conexao = conectarBD();
    $query = "SELECT id, senha FROM usuarios_administrativos WHERE login = $1 AND status = TRUE";
    $resultado = pg_query_params($conexao, $query, [$login]);
    $usuario = pg_fetch_assoc($resultado);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_logado'] = $usuario['id'];
        header('Location: ../public/admin.php');
        exit();
    } else {
        return "Login ou senha incorretos!";
    }
}

// Função para processar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../public/login.php');
    exit();
}

// Processar login
if (isset($_POST['login'])) {
    $login = sanitizarEntrada($_POST['login']);
    $senha = sanitizarEntrada($_POST['senha']);
    $erro = login($login, $senha);
}

function cadastrarUsuario($login, $senha) {
    // Conecta ao banco de dados
    $conexao = conectarBD();

    // Gera o hash da senha com password_hash
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // SQL para inserir o usuário
    $query = "INSERT INTO usuarios_administrativos (login, senha) VALUES ($1, $2)";

    // Executa a query com parâmetros de forma segura
    $resultado = pg_query_params($conexao, $query, [$login, $senhaHash]);

    // Verifica se a inserção foi bem-sucedida
    if ($resultado) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o usuário.";
    }

    // Fecha a conexão com o banco de dados
    pg_close($conexao);
}

// Exemplo de uso da função
//cadastrarUsuario('admin', 'senha123');

?>