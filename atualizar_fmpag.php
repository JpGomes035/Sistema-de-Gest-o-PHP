<?php
include_once 'iniciar_sessao.php';
//atualizar os dados da edição de categoria
include_once 'conexao.php';

$id_fmpag = $_POST['id_fmpag'];
$nome_fmpag = $_POST['nome_fmpag'];
$banco_vinculado = $_POST['banco_vinculado'];
$percentual_taxa = $_POST['percentual_taxa'];

$sql = "UPDATE fm_pag SET nome_fmpag = '$nome_fmpag', banco_vinculado = '$banco_vinculado', percentual_taxa = '$percentual_taxa', id_reg_edit = '$usuarioLogado' WHERE id_fmpag = $id_fmpag";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_formpag.php?atualizado=".$id_fmpag); 
}
?>
