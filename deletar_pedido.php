<?php
include_once 'conexao.php';
//apagar um pedido
$idPedido = $_GET['idPedido'];
$sql = "DELETE FROM pedido WHERE idPedido = $idPedido";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_entregue.php?excluido=".$idPedido); 
}
?>
