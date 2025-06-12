<?php
include_once 'iniciar_sessao.php';
//atualizar os dados da edição de entrada
include_once 'conexao.php';


$id = $_POST['id'];
$quantos = $_POST['quantos'];
$descricao = $_POST['descricao'];
$fmpag = $_POST['fmpag'];
$responsavel= $_POST['responsavel'];
$data= $_POST['data'];
$nomeCliente = $_POST['nome'];
$nomeBanco = $_POST['nomeBanco'];



$sql = "UPDATE entrada SET quantos = '$quantos', descricao = '$descricao', fmpag = '$fmpag', responsavel = '$responsavel', data = '$data',  nome = '$nomeCliente', nomeBanco = '$nomeBanco', id_reg_edit = $usuarioLogado" .
" WHERE id = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_entrada.php?atualizado=".$id); 
}
?>
