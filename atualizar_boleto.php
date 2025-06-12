<?php
// Atualizar os dados da edição de boleto
include_once 'conexao.php';

$id = $_POST['idBoleto'];
$numeroBoleto = $_POST['numeroBoleto'];
$valor = $_POST['valor'];
$dataEmissao = $_POST['dataEmissao'];
$dataVencimento = $_POST['dataVencimento'];
$beneficiario = $_POST['beneficiario'];
$pagadorNome = $_POST['pagadorNome'];
$pagadorCPF = $_POST['pagadorCPF'];
$statusPagamento = $_POST['statusPagamento'];

$sql = "UPDATE boletos SET 
        numero_boleto = '$numeroBoleto', 
        valor = '$valor', 
        data_emissao = '$dataEmissao', 
        data_vencimento = '$dataVencimento', 
        beneficiario = '$beneficiario', 
        pagador_nome = '$pagadorNome', 
        pagador_cpf = '$pagadorCPF', 
        status_pagamento = '$statusPagamento' 
        WHERE id_boleto = $id";

$update = mysqli_query($conexao, $sql);

if ($update) {
    header("Location: listar_boleto.php?atualizado=" . $id);
} else {
    // Tratar o caso em que a atualização falha
    echo "Erro na atualização: " . mysqli_error($conexao);
}
?>
