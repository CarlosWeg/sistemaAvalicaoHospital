<?php
function sanitizarEntrada($dado) {
    return htmlspecialchars(trim($dado), ENT_QUOTES, 'UTF-8');
}
?>