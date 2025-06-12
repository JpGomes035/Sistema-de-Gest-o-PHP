<?php
//inserir a edição de algum banco ou conta cadastrada
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id = $_POST['idBanco'];
$nomeBanco = $_POST['nomeBanco'];
$agencia = $_POST['agencia'];
$cc = $_POST['cc'];
$valor_banco = $_POST['valor_banco'];

$sql = "UPDATE banco SET nomeBanco = '$nomeBanco', agencia = '$agencia', cc = '$cc', valor_banco = '$valor_banco' WHERE idBanco = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_banco.php?atualizado=".$id); 
}
?>
