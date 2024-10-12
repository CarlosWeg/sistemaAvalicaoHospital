<?php
require_once '../config.php';

function conectarBD() {
    $conexao = pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS);
    if (!$conexao) {
        die("Erro na conexão com o banco de dados.");
    }
    return $conexao;
}
?>
