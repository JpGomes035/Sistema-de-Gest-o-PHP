<?php

//deixar como agenda concluida no sistema só que no painel (opção nao existe mais)
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$idAgenda = $_GET['idAgenda'];
$sql = "DELETE FROM agenda WHERE idAgenda = $idAgenda";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: painel.php?excluido=".$idAgenda); 
}
?>
