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
</head>
<body>
    <div class="container">
        <img src="https://www.hrav.com.br/wp-content/uploads/2024/08/logo-white.png" alt="Logo do Hospital Regional do Alto Vale" class="logo">
        
        <h1>Avaliação de Serviços</h1>
        
        <form action="../src/respostas.php" method="POST">
            <?php foreach ($perguntas as $pergunta): ?>
                <div class="pergunta">
                    <label><?= sanitizarEntrada($pergunta['texto']); ?></label>
                    <div class="escala">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <label>
                                <input type="radio" name="respostas[<?= $pergunta['id']; ?>]" value="<?= $i; ?>" required>
                                <?= $i; ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <label for="feedback">Feedback adicional (opcional):</label>
            <textarea name="feedback" id="feedback"></textarea>

            <button type="submit">Enviar Avaliação</button>
        </form>
        
        <footer>
            <p>Sua avaliação é anônima. Nenhuma informação pessoal será armazenada.</p>
        </footer>
    </div>
</body>
</html>