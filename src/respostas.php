<?php
require_once 'db.php';
require_once 'funcoes.php';

function processarRespostas() {
    // Verifica se o formulário foi enviado via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Exemplo de IDs fixos para setor e dispositivo (em um sistema real, isso pode vir de outra seleção ou ser capturado dinamicamente)
        $setor_id = 1;  // Exemplo: Recepção
        $dispositivo_id = 1;  // Exemplo: Tablet 1

        // Sanitizar e validar o feedback opcional
        $feedback = isset($_POST['feedback']) ? sanitizarEntrada($_POST['feedback']) : null;

        // Verifica se as respostas foram enviadas corretamente
        if (isset($_POST['respostas']) && is_array($_POST['respostas'])) {
            $respostas = $_POST['respostas'];

            // Conectar ao banco de dados
            $conexao = conectarBD();

            // Iniciar a transação para garantir que todas as respostas sejam salvas
            pg_query($conexao, 'BEGIN');

            try {
                // Inserir cada resposta no banco de dados
                foreach ($respostas as $pergunta_id => $resposta) {
                    // Validação básica: garantir que a resposta esteja entre 0 e 10
                    if (!is_numeric($resposta) || $resposta < 0 || $resposta > 10) {
                        throw new Exception("Respostas inválidas!");  // Se a resposta for inválida
                    }

                    // Query para inserir cada avaliação no banco
                    $query = "INSERT INTO avaliacoes (setor_id, pergunta_id, dispositivo_id, resposta, feedback) 
                              VALUES ($1, $2, $3, $4, $5)";
                    
                    // Executa a query para salvar a resposta no banco
                    $resultado = pg_query_params($conexao, $query, [$setor_id, $pergunta_id, $dispositivo_id, $resposta, $feedback]);

                    if (!$resultado) {
                        throw new Exception("Erro ao inserir as respostas no banco de dados.");
                    }
                }

                // Commit da transação se tudo estiver correto
                pg_query($conexao, 'COMMIT');

                // Fechar a conexão após o commit
                pg_close($conexao);

                // Redirecionar para a página de agradecimento
                header('Location: ../public/obrigado.php');
                exit();

            } catch (Exception $e) {
                // Em caso de erro, reverte a transação
                pg_query($conexao, 'ROLLBACK');
                pg_close($conexao);
                die($e->getMessage());
            }

        } else {
            echo "Nenhuma resposta foi enviada!";
        }
    } else {
        echo "Método de requisição inválido!";
    }
}

// Chama a função de processamento quando o script for executado
processarRespostas();
?>
