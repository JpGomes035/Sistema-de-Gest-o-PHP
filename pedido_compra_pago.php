<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$codigo_pedido = $_GET['codigo_pedido'];
$sql = "UPDATE pedido_compra SET pago = 'S' WHERE codigo_pedido = $codigo_pedido";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_pedido_compras.php?pago=".$codigo_pedido); 
}
?>
