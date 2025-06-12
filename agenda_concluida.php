<?php
//Deixar como agenda concluida

include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$idAgenda = $_GET['idAgenda'];
$sql = "DELETE FROM agenda WHERE idAgenda = $idAgenda";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: agenda.php?excluido=".$idAgenda); 
}
?>
