<?php
require_once '../src/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - HRAV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login Administrativo</h1>
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?= $erro; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>
            <br><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <br><br>
            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>
