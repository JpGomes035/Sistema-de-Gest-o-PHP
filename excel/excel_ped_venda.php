<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel</title>
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
header("Content-Disposition: attachment; filename=relatorio_pedido_vendas.xls");



// Consulta SQL para obter os dados do relatório
$sql = "SELECT codigo_pedido, nome_cliente, responsavel_pedido, observacoes, valor_total, data, pago, fm_pag FROM `pedidos` where deletado = 'N' ORDER BY codigo_pedido DESC";
$resultado = mysqli_query($conexao, $sql);

// Inicializar a saída do Excel
echo '<table>';
echo '<tr><th>Codigo_pedido</th><th>Nome_cliente</th><th>Responsavel_pedido</th><th>Observacoes</th><th>Valor_total</th><th>Data</th><th>Pago</th><th>Forma de Pagamento</th></tr>';


$total = 0;
// Loop pelos resultados e imprimir cada linha no arquivo Excel
while ($row = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';
    echo '<td>' . escape_for_excel($row['codigo_pedido']) . '</td>';
    echo '<td>' . escape_for_excel($row['nome_cliente']) . '</td>';
    echo '<td>' . escape_for_excel($row['responsavel_pedido']) . '</td>';
    echo '<td>' . escape_for_excel($row['observacoes']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor_total']) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data']))) . '</td>';
    echo '<td>' . escape_for_excel($row['pago']) . '</td>';
    echo '<td>' . escape_for_excel($row['fm_pag']) . '</td>';
    echo '</tr>';
    $total += floatval($row['valor_total']);
}
// Adiciona a linha com o valor total
echo '<tr>';
echo '<td colspan="7"><b>Total:</b></td>';
echo '<td>' . escape_for_excel(number_format($total, 2, ',', '.')) . '</td>';
echo '</tr>';
echo '</table>';
?>

</body>
</html>