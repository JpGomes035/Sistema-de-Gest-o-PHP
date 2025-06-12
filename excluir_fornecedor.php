<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$id = $_GET['id'];
$sql = "DELETE FROM fornecedor WHERE IdFornecedor = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_fornecedor.php?excluido=".$id); 
}
?>
