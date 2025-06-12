<?php
//atualizar os dados da edição de estorno de pagamento
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id_Contaspagar = $_POST['id_Contaspagar'];
$numero_documento = $_POST['numero_documento'];
$valor_parcela = $_POST['valor_parcela'];
$valor_compra = $_POST['valor_compra'];
$valor_abatido = $_POST['valor_abatido'];
$data_compra = $_POST['data_compra'];
$data_vencimento = $_POST['data_vencimento'];
$data_pagamento  = $_POST['data_pagamento'];



$sql = "UPDATE contas_pagar SET id_Contaspagar = $id_Contaspagar, numero_documento = '$numero_documento', valor_parcela = $valor_parcela, valor_compra = $valor_compra, valor_abatido = $valor_abatido, data_compra = '$data_compra', data_vencimento = '$data_vencimento',  data_pagamento = '$data_pagamento', status = 'N'" .
" WHERE id_Contaspagar = $id_Contaspagar";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_contas_pagar.php?estorno=".$id_Contaspagar); 
}
?>
