<?php
session_start();
include_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Atualiza o status do usuário para offline
$sqlUpdateOffline = "UPDATE usuario SET Online = '0' WHERE IdUsuario = ?";
$stmt = mysqli_prepare($conexao, $sqlUpdateOffline);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);

if (mysqli_stmt_execute($stmt)) {
    // Sucesso no update
    session_unset();
    session_destroy();
    header("Location: index.html");
} else {
    // Erro no update
    echo "Erro ao atualizar status: " . mysqli_error($conexao);
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
exit();
?>
