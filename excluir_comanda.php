<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$idComanda = $_GET['idComanda'];
$sql = "DELETE FROM comanda WHERE idComanda = $idComanda";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_comanda.php?excluido=".$idComanda); 
}
?>
