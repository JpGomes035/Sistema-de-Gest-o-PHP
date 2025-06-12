<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doc</title>
    <style>
    /* Estilo para o cabeçalho da tabela */
    
    th {
            background-color: black;
            color: white;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 8px; /* Adicionando padding para melhor visualização */
        }

        /* Estilo para as células da tabela */
        td {
            background-color: #f9f9f9;
            color: #000;
            text-align: center;
            border: 1px solid #000;
            padding: 8px; /* Adicionando padding para melhor visualização */
        }

        /* Estilo para a tabela */
        table {
            border-collapse: collapse; /* Mesclar bordas de células */
            width: 100%;
        }

        /* Estilo para a primeira linha (cabeçalho) */
        tr:first-child {
            background-color: #333;
            color: #fff;
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
header("Content-Disposition: attachment; filename=relatorio_boletos.xls");

// Consulta SQL para obter os dados do relatório
$sql = "SELECT numero_boleto, valor, data_emissao, data_vencimento, beneficiario, pagador_nome, pagador_cpf, status_pagamento FROM `boletos` WHERE deletado = 'N' ORDER BY numero_boleto DESC";
$resultado = mysqli_query($conexao, $sql);

// Inicializar a saída do Excel
echo '<table>';
echo '<tr><th>Número do Boleto</th><th>Valor</th><th>Data de Emissão</th><th>Data de Vencimento</th><th>Beneficiário</th><th>Nome do Pagador</th><th>CPF do Pagador</th><th>Status do Pagamento</th></tr>';

// Variável para armazenar o valor total
$total = 0;

// Loop pelos resultados e imprimir cada linha no arquivo Excel
while ($row = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';
    echo '<td>' . escape_for_excel($row['numero_boleto']) . '</td>';
    echo '<td>' . escape_for_excel($row['valor']) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_emissao']))) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data_vencimento']))) . '</td>';
    echo '<td>' . escape_for_excel($row['beneficiario']) . '</td>';
    echo '<td>' . escape_for_excel($row['pagador_nome']) . '</td>';
    echo '<td>' . escape_for_excel($row['pagador_cpf']) . '</td>';
    echo '<td>' . escape_for_excel($row['status_pagamento']) . '</td>';
    echo '</tr>';

    // Adiciona o valor do boleto ao total
    $total += floatval($row['valor']);
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