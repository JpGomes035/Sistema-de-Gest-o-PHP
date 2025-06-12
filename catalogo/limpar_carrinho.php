<?php
session_start();

// Limpa o carrinho
if (isset($_SESSION['carrinho'])) {
    unset($_SESSION['carrinho']);
}

// Redireciona para a página do carrinho
header('Location: visualizar_carrinho.php');
?>
