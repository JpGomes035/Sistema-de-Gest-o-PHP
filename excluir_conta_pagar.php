<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';

$id_Contaspagar = $_GET['id_Contaspagar'];

$sql = "DELETE FROM contas_pagar WHERE id_Contaspagar = $id_Contaspagar";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_contas_pagar.php?excluido=".$id_Contaspagar); 
}
?>
