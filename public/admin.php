<?php
require_once '../src/auth.php';  // Sistema de autenticação
require_once '../src/perguntas.php';
require_once '../src/funcoes.php';

// Verificar se o usuário está autenticado
verificarAutenticacao();

$perguntas = obterPerguntas();
$avaliacoes = obterAvaliacoes();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - HRAV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Painel Administrativo</h1>

        <!-- Formulário para cadastro de nova pergunta -->
        <h2>Cadastrar Nova Pergunta</h2>
        <form action="../src/perguntas.php" method="POST">
            <label for="nova-pergunta">Texto da pergunta:</label>
            <input type="text" id="nova-pergunta" name="texto_pergunta" required>
            <input type="submit" name="cadastrar_pergunta" value="Cadastrar">
        </form>

        <!-- Listagem das perguntas cadastradas -->
        <h2>Gerenciar Perguntas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Texto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perguntas as $pergunta): ?>
                    <tr>
                        <td><?= $pergunta['id']; ?></td>
                        <td><?= sanitizarEntrada($pergunta['texto']); ?></td>
                        <td>
                            <a href="../src/perguntas.php?editar=<?= $pergunta['id']; ?>">Editar</a> |
                            <a href="../src/perguntas.php?remover=<?= $pergunta['id']; ?>" onclick="return confirm('Tem certeza que deseja remover esta pergunta?');">Remover</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Visualização das avaliações -->
        <h2>Visualizar Avaliações</h2>
        <table>
            <thead>
                <tr>
                    <th>Setor</th>
                    <th>Pergunta</th>
                    <th>Dispositivo</th>
                    <th>Resposta</th>
                    <th>Feedback</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <tr>
                        <td><?= sanitizarEntrada($avaliacao['nome_setor']); ?></td>
                        <td><?= sanitizarEntrada($avaliacao['texto_pergunta']); ?></td>
                        <td><?= sanitizarEntrada($avaliacao['nome_dispositivo']); ?></td>
                        <td><?= $avaliacao['resposta']; ?></td>
                        <td><?= sanitizarEntrada($avaliacao['feedback']); ?></td>
                        <td><?= $avaliacao['data_hora']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="../src/auth.php?logout=true">Sair</a>
    </div>
</body>
</html>