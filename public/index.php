<?php
require_once '../src/perguntas.php';
require_once '../src/funcoes.php';
$perguntas = obterPerguntas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação HRAV</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <img src="https://www.hrav.com.br/wp-content/uploads/2024/08/logo-white.png" alt="Logo do Hospital Regional do Alto Vale" class="logo">
        
        <h1>Avaliação de Serviços</h1>
        <p>Pontuação de 0 (MUITO INSATISFEITO) a 10 (COMPLETAMENTE SATISFEITO).</p>
        
        <form id="formulario" action="../src/respostas.php" method="POST">
            <?php foreach ($perguntas as $index => $pergunta): ?>
                <div class="pergunta" style="display: none;">
                    <label><?= sanitizarEntrada($pergunta['texto']); ?></label>
                    <div class="escala">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <label class="label-escala" style="background-color: <?= corEscala($i); ?>;">
                                <input type="radio" name="respostas[<?= $pergunta['id']; ?>]" value="<?= $i; ?>" required>
                                <?= $i; ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Feedback adicional aparece após as perguntas -->
            <div class="feedback" style="display: none;">
                <label for="feedback">Feedback adicional (opcional):</label>
                <textarea name="feedback" id="feedback"></textarea>
            </div>

            <br>

            <button type="button" onclick="proximaPergunta()">Próxima</button>
            
        </form>
        
        <footer>
            <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </footer>
    </div>
</body>
</html>
