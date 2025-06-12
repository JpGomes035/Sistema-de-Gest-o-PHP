<?php
include_once 'conexao.php';

//atualizar os dados da edição de cliente
$id = $_POST['idCliente'];
$nomeCliente = $_POST['nomeCliente'];
$numeroCliente = $_POST['numeroCliente'];
$emailCliente = $_POST['emailCliente'];
$cepCliente = $_POST['cepCliente'];
$cpfCliente = $_POST['cpfCliente'];

$sql = "UPDATE cliente SET nomeCliente = '$nomeCliente', numeroCliente = '$numeroCliente', emailCliente = '$emailCliente', cepCliente = '$cepCliente', cpfCliente = '$cpfCliente' WHERE idCliente = $id";
$update = mysqli_query($conexao, $sql);

if ($update) {
    header("Location: listar_cliente.php?atualizado=" . $id);
}
