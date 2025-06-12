<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$id = $_GET['id'];
$sql = "UPDATE entrada SET deletado = 'S', id_reg_delet = $usuarioLogado WHERE id = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_entrada.php?excluido=".$id); 
}
?>
