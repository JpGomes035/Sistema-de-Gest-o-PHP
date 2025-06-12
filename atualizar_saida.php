<?php
//atualizar os dados da edição de saída
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id = $_POST['id'];
$quantos = $_POST['quantos'];
$descricao = $_POST['descricao'];
$fmpag = $_POST['fmpag'];
$responsavel= $_POST['responsavel'];
$data = $_POST['data'];
$nomeBanco = $_POST['nomeBanco'];


$sql = "UPDATE saida SET quantos = '$quantos', descricao = '$descricao', fmpag = '$fmpag', responsavel = '$responsavel', data = '$data', nomeBanco = '$nomeBanco', id_reg_edit = $usuarioLogado" .
       " WHERE id = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_saida.php?atualizado=".$id); 
}
?>
