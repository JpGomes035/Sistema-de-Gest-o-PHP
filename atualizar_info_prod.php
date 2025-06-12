<?php
//atualizar os dados da edição das info do produto
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id = $_POST['idProduto'];
$descProd = $_POST['descProd'];
$vencProd = $_POST['vencProd'];
$unidade_estoque = $_POST['unidade_estoque'];
$peso = $_POST['peso'];
$precoPromocional = $_POST['precoPromocional'];
$status_prod = $_POST['status_prod'];
$preco_custo = $_POST['preco_custo'];
$preco_bruto = $_POST['preco_bruto'];
$localEstoq = $_POST['localEstoq'];

$sql = "UPDATE estoque SET descProd = '$descProd', vencProd = '$vencProd', unidade_estoque = '$unidade_estoque', peso = '$peso', precoPromocional = '$precoPromocional', status_prod = '$status_prod', preco_custo = '$preco_custo', preco_bruto = '$preco_bruto', localEstoq = '$localEstoq'" .
       " WHERE IdProduto = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_produtos.php?atualizado=".$id); 
}
?>