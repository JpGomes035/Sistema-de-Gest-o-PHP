<?php
// Atualiza os dados da edição de transporte
include_once 'conexao.php';

$id = $_POST['idTransporte'];
$pedido_id = $_POST['pedido_id'];
$tipo_pedido = $_POST['tipo_pedido'];
$valor_transporte = $_POST['valor_transporte'];
$veiculo_placa = $_POST['veiculo_placa'];
$data_transporte = $_POST['data_transporte'];
$Concluido = $_POST['Concluido'];

$sql = "UPDATE Transportes SET pedido_id = '$pedido_id', tipo_pedido = '$tipo_pedido', valor_transporte = '$valor_transporte', veiculo_placa = '$veiculo_placa', Concluido = '$Concluido', data_transporte = '$data_transporte' WHERE id = $id";
$update = mysqli_query($conexao, $sql);

if ($update) {
    header("Location: listar_transportes.php?atualizado=" . $id);
}
?>
