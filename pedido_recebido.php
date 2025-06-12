<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$codigo_pedido = $_GET['codigo_pedido'];
$sql = "UPDATE pedidos SET pago = 'S' WHERE codigo_pedido = $codigo_pedido";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_pedidos.php?recebido=".$codigo_pedido); 
}
?>
