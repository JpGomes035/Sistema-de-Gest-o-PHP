<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doc</title>
    <style>
    /* Estilo para o cabeçalho da tabela */
    th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
        text-align: center;
        border: 2px solid black;
    }

    /* Estilo para as células da tabela */
    td {
        background-color: #f9f9f9;
        color: #000;
        text-align: center;
        border: 1px solid #000;
    }

    /* Adicione mais estilos conforme necessário */
</style>
</head>
<body>
<?php
// Incluir o arquivo de conexão com o banco de dados e iniciar a sessão, se necessário
include_once '../iniciar_sessao.php';
include_once '../conexao.php';

// Função para escapar caracteres especiais em uma string para uso em uma célula do Excel
function escape_for_excel($string) {
    // Escape de aspas duplas
    $string = str_replace('"', '""', $string);
    return $string;
}

// Cabeçalho para forçar o download de um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=relatorio_contas_pagar/pagas.xls");

// Consulta SQL para obter os dados do relatório
$sql = "SELECT numero_documento, descricao_pagar, valor_parcela, valor_compra, valor_abatido, data_compra, data_cadastro, data_vencimento,status, cliente FROM `contas_pagar` ORDER BY numero_documento DESC";
$resultado = mysqli_query($conexao, $sql);

// Inicializar a saída do Excel
echo '<table>';
echo '<tr><th>Número do Documento</th><th>Descrição a Pagar</th><th>Valor da Parcela</th><th>Valor da Compra</th><th>Valor Abatido</th><th>Cliente</th><th>Data da Compra</th><th>Data de Cadastro</th><th>Data de Vencimento</th><th>PAGO</th></tr>';

$total = 0;

// Loop pelos resultados e imprimir cada linha no arquivo Excel
while ($row = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';
    echo '<td>' . escape_for_excel($row['numero_documento']) . '</td>';
    echo '<td>' . escape_for_excel($row['descricao_pagar']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor_parcela']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor_compra']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor_abatido']) . '</td>';
    echo '<td>' . escape_for_excel($row['cliente']) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_compra']))) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_cadastro']))) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_vencimento']))) . '</td>';
    echo '<td>' . escape_for_excel($row['status']) . '</td>';
    echo '</tr>';
    $total += floatval($row['valor_parcela']);
}

echo '<tr>';
echo '<td colspan="7"><b>Valor de Parcelas:</b></td>';
echo '<td>' . escape_for_excel(number_format($total, 2, ',', '.')) . '</td>';
echo '</tr>';
echo '</table>';
?>

</body>
</html>
