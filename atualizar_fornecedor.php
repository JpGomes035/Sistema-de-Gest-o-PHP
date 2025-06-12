<?php
//atualizar os dados da edição de fornecedor
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id = trim($_POST['IdFornecedor']);
$nomeForn = trim($_POST["nomeForn"]);
$cnpjForn = trim($_POST["cnpjForn"]);
$telefoneForn = trim($_POST["telefoneForn"]);
$cepForn = trim($_POST["cepForn"]);
$emailForn = trim($_POST["emailForn"]);
$cod_Forn= trim($_POST["cod_Forn"]);

$sql = "UPDATE fornecedor SET nomeForn = '$nomeForn',  cnpjForn = '$cnpjForn',  telefoneForn = '$telefoneForn',  cepForn = '$cepForn',  emailForn = '$emailForn', cod_Forn = '$cod_Forn' WHERE IdFornecedor = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_fornecedor.php?atualizado=".$id); 
}
?>
