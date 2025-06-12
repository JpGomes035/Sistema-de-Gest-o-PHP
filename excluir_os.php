<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$idOs = $_GET['idOs'];

$sql = "DELETE FROM ordem_servico WHERE idOs = $idOs";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_os.php?excluido=".$idOs); 
}
?>
