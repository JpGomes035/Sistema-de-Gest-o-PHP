<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';

$id_Contasreceber = $_GET['id_Contasreceber'];

$sql = "DELETE FROM contas_receber WHERE id_Contasreceber = $id_Contasreceber";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_contas_receber.php?excluido=".$id_Contasreceber); 
}
?>
