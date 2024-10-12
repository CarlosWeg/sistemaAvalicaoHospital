<?php

require_once 'db.php';

function sanitizarEntrada($dado) {
    return htmlspecialchars(trim($dado), ENT_QUOTES, 'UTF-8');
}

function corEscala($valor) {
    $cores = [
        '#FF0000', // 0 - Vermelho
        '#FF3300', // 1 - Laranja escuro
        '#FF6600', // 2 - Laranja
        '#FF9900', // 3 - Amarelo escuro
        '#FFCC00', // 4 - Amarelo
        '#FFFF00', // 5 - Amarelo claro
        '#CCFF33', // 6 - Verde amarelado
        '#99FF33', // 7 - Verde claro
        '#66FF33', // 8 - Verde médio
        '#33FF33', // 9 - Verde
        '#00FF00', // 10 - Verde intenso
    ];

    return $cores[$valor];
}

function obterAvaliacoes() {
    $conexao = conectarBD();
    $query = "
        SELECT setores.nome AS nome_setor, perguntas.texto AS texto_pergunta, dispositivos.nome AS nome_dispositivo, 
               avaliacoes.resposta, avaliacoes.feedback, avaliacoes.data_hora
        FROM avaliacoes
        JOIN setores ON avaliacoes.setor_id = setores.id
        JOIN perguntas ON avaliacoes.pergunta_id = perguntas.id
        JOIN dispositivos ON avaliacoes.dispositivo_id = dispositivos.id
        ORDER BY avaliacoes.data_hora DESC";
    $resultado = pg_query($conexao, $query);
    return pg_fetch_all($resultado);
}



?>