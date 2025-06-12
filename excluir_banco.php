<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM banco WHERE idBanco = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_banco.php?excluido=".$id); 
}
?>
