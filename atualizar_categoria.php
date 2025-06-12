<?php
//atualizar os dados da edição de categoria
include_once 'conexao.php';

$id = $_POST['idCategoria'];
$categoria = $_POST['nomeCategoria'];
$catalogo = $_POST['catalogo'];

$sql = "UPDATE categoria SET Nome = '$categoria', catalogo = '$catalogo' WHERE IdCategoria = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_categorias.php?atualizado=".$id); 
}
?>
