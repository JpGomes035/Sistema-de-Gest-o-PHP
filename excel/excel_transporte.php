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

// Consulta SQL para obter os dados da tabela "transportes"
$sql_transportes = "SELECT pedido_id, tipo_pedido, valor_transporte, veiculo_placa, data_cadastro_transporte, concluido FROM `transportes` WHERE deletado = 'N'";
$resultado_transportes = mysqli_query($conexao, $sql_transportes);

// Cabeçalho para forçar o download de um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=relatorio_transportes.xls");

// Inicializar a saída do Excel
echo '<table>';
echo '<tr><th>Pedido ID</th><th>Tipo de Pedido</th><th>Valor do Transporte</th><th>Placa do Veiculo</th><th>Data de Cadastro</th><th>Status</th></tr>';
$total = 0;
// Loop para a tabela "transportes"
while ($row = mysqli_fetch_assoc($resultado_transportes)) {
    echo '<tr>';
    echo '<td>' . escape_for_excel($row['pedido_id']) . '</td>';
    echo '<td>' . escape_for_excel($row['tipo_pedido']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor_transporte']) . '</td>';
    echo '<td>' . escape_for_excel($row['veiculo_placa']) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_cadastro_transporte']))) . '</td>';
    echo '<td>' . escape_for_excel($row['concluido']) . '</td>';
    echo '</tr>';
    $total += floatval($row['valor_transporte']);
}
echo '<tr>';
echo '<td colspan="7"><b>Total:</b></td>';
echo '<td>' . escape_for_excel(number_format($total, 2, ',', '.')) . '</td>';
echo '</tr>';

echo '</table>';
?>
</body>
</html>
