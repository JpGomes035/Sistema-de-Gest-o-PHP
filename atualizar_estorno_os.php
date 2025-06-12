<?php
//atualizar os dados da edição de estorno de OS
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$idOs = trim($_POST["idOs"]);
$responsavel = trim($_POST["responsavel"]);
$descricaoOs = trim($_POST["descricaoOs"]);
$data_inicioOs = trim($_POST["data_inicioOs"]);
$data_terminoOs = trim($_POST["data_terminoOs"]);
$valorOs = trim($_POST["valorOs"]);
$tipoOs = trim($_POST["tipoOs"]);
$statusOs = trim($_POST["statusOs"]);
$clienteOs = trim($_POST["clienteOs"]);


$sql = "UPDATE ordem_servico SET responsavel = '$responsavel', descricaoOs = '$descricaoOs', data_inicioOs = '$data_inicioOs', valorOs = '$valorOs', tipoOs = '$tipoOs', statusOs = '$statusOs', clienteOs = '$clienteOs', data_terminoOs = '$data_terminoOs', status = 'A'" .
       " WHERE idOs = $idOs";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_os_finalizada.php?estornado=".$idOs); 
}
?>