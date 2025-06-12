<?php
//atualizar os dados da edição de conta recebida
include_once 'conexao.php';

$id_Contasreceber = $_POST['id_Contasreceber'];
$numero_documento = $_POST['numero_documento'];
$valor_parcela = $_POST['valor_parcela'];
$valor_venda = $_POST['valor_venda'];
$valor_abatido = $_POST['valor_abatido'];
$data_venda = $_POST['data_venda'];
$data_vencimento = $_POST['data_vencimento'];
$data_recebimento  = $_POST['data_recebimento'];


$sql = "UPDATE contas_receber SET id_Contasreceber = $id_Contasreceber, numero_documento = '$numero_documento', valor_parcela = $valor_parcela, valor_venda = $valor_venda, valor_abatido = $valor_abatido, data_venda = '$data_venda', data_vencimento = '$data_vencimento',  data_recebimento = '$data_recebimento', status = 'S'" .
" WHERE id_Contasreceber = $id_Contasreceber";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_contas_receber.php?recebimento=".$id_Contasreceber); 
}
?>
