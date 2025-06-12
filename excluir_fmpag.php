<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$id_fmpag = $_GET['id_fmpag'];
$sql = "UPDATE fm_pag SET deletado = 'S', id_reg_delet = $usuarioLogado WHERE id_fmpag = $id_fmpag";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_formpag.php?excluido=".$id_fmpag); 
}
?>
