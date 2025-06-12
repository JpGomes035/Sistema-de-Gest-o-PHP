<?php
include_once 'conexao.php';
// Check if the user is logged in
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"] == null) {
    header("Location: index.html");
    exit(); // Stop further execution
}
// Get the logged-in user's ID
$usuarioLogado = $_SESSION["usuario"];
// Retrieve the user's level from the database
$sql = "SELECT NivelUsuario FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
$retorno = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($retorno);
$nivel = $array['NivelUsuario'];
?>