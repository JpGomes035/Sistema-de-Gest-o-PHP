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

// Consulta SQL para obter os dados da tabela "entrada"
$sql_entrada = "SELECT id, quantos, descricao, fmpag, responsavel, data, datareg, nome, nomeBanco, id_reg FROM `entrada` WHERE deletado = 'N'";
$resultado_entrada = mysqli_query($conexao, $sql_entrada);

// Cabeçalho para forçar o download de um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=relatorio_entrada.xls");

// Inicializar a saída do Excel
echo '<table>';
echo '<tr><th>ID</th><th>Valor</th><th>Descrição</th><th>Forma de Pagamento</th><th>Responsável</th><th>Data</th><th>Data de Registro</th><th>Nome</th><th>Nome do Banco</th><th>Usuário que registrou</th></tr>';
$total = 0;
// Loop para a tabela "entrada"
while ($row = mysqli_fetch_assoc($resultado_entrada)) {
    echo '<tr>';
    echo '<td>' . escape_for_excel($row['id']) . '</td>';
    echo '<td>' . escape_for_excel($row['quantos']) . '</td>';
    echo '<td>' . escape_for_excel($row['descricao']) . '</td>';
    echo '<td>' . escape_for_excel($row['fmpag']) . '</td>';
    echo '<td>' . escape_for_excel($row['responsavel']) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['data']))) . '</td>';
    echo '<td>' . escape_for_excel(date("d/m/Y", strtotime($row['datareg']))) . '</td>';
    echo '<td>' . escape_for_excel($row['nome']) . '</td>';
    echo '<td>' . escape_for_excel($row['nomeBanco']) . '</td>';
    echo '<td>' . escape_for_excel($row['id_reg']) . '</td>';
    echo '</tr>';
    $total += floatval($row['quantos']);
}
echo '<tr>';
echo '<td colspan="7"><b>Total:</b></td>';
echo '<td>' . escape_for_excel(number_format($total, 2, ',', '.')) . '</td>';
echo '</tr>';
echo '</table>';
?>
</body>
</html>