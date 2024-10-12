<?php
require_once 'src/db.php'; // Conexão com o banco de dados
require_once 'src/funcoes.php'; // Arquivo para funções auxiliares (sanitização, etc.)

$conn = conectarBanco(); // Função para conectar ao PostgreSQL

// Carregar perguntas do banco de dados
$query = "SELECT id, texto FROM perguntas WHERE status = TRUE ORDER BY id";
$result = pg_query($conn, $query);
$perguntas = pg_fetch_all($result);

$erro = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setor_id = sanitizar($_POST['setor_id']);
    $dispositivo_id = sanitizar($_POST['dispositivo_id']);
    $respostas = $_POST['respostas']; // Array com respostas das perguntas
    $feedback = isset($_POST['feedback']) ? sanitizar($_POST['feedback']) : NULL;

    // Verificar se todas as respostas estão válidas (0-10)
    foreach ($respostas as $pergunta_id => $resposta) {
        if ($resposta < 0 || $resposta > 10) {
            $erro = 'Respostas inválidas. Todas as notas devem estar entre 0 e 10.';
            break;
        }
    }

    if (empty($erro)) {
        // Inserir cada resposta no banco de dados
        foreach ($respostas as $pergunta_id => $resposta) {
            $query = "INSERT INTO avaliacoes (setor_id, pergunta_id, dispositivo_id, resposta, feedback, data_hora) 
                      VALUES ($1, $2, $3, $4, $5, NOW())";
            $params = [$setor_id, $pergunta_id, $dispositivo_id, $resposta, $feedback];
            pg_query_params($conn, $query, $params);
        }

        $sucesso = true; // Exibir mensagem de agradecimento após submissão bem-sucedida
    }
}
?>

<!DOCTYPE HTML>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Avaliação de Serviços - HRAV</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Sistema de Avaliação</h1>

    <?php if ($sucesso): ?>
        <p>O Hospital Regional Alto Vale (HRAV) agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.</p>
    <?php else: ?>
        <?php if (!empty($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <label for="setor_id">Selecione o Setor:</label>
            <select name="setor_id" id="setor_id" required>
                <!-- Aqui você pode carregar os setores dinamicamente -->
                <option value="1">Recepção</option>
                <option value="2">Enfermagem</option>
                <option value="3">Emergência</option>
                <!-- Adicionar mais setores conforme necessário -->
            </select>

            <label for="dispositivo_id">ID do Dispositivo:</label>
            <input type="text" name="dispositivo_id" id="dispositivo_id" value="1" required /> <!-- Defina dinamicamente o ID do dispositivo -->

            <h2>Avaliação de Serviços</h2>
            <?php if ($perguntas): ?>
                <?php foreach ($perguntas as $pergunta): ?>
                    <label><?php echo $pergunta['texto']; ?></label>
                    <input type="number" name="respostas[<?php echo $pergunta['id']; ?>]" min="0" max="10" required />
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma pergunta disponível.</p>
            <?php endif; ?>

            <label for="feedback">Comentário adicional (opcional):</label>
            <textarea name="feedback" id="feedback"></textarea>

            <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>

            <button type="submit">Enviar Avaliação</button>
        </form>
    <?php endif; ?>
</body>

</html>