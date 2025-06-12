<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel</title>
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
    header("Content-Disposition: attachment; filename=relatorio_banco.xls");

    // Consulta SQL para obter os dados do relatório
    $sql = "SELECT nomeBanco, agencia, cc, valor_banco FROM `banco`";
    $resultado = mysqli_query($conexao, $sql);

    // Inicializar a saída do Excel
    echo '<table>';
    echo '<tr><th>Nome do Banco</th><th>Agencia</th><th>Conta Corrente</th><th>Valor no Banco</th></tr>';

    // Variável para armazenar o valor total no banco
    $total_banco = 0;

    // Loop pelos resultados e imprimir cada linha no arquivo Excel
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo '<tr>';
        echo '<td>' . escape_for_excel($row['nomeBanco']) . '</td>';
        echo '<td>' . escape_for_excel($row['agencia']) . '</td>';
        echo '<td>' . escape_for_excel($row['cc']) . '</td>';
        echo '<td>' . escape_for_excel($row['valor_banco']) . '</td>';
        echo '</tr>';

        // Adiciona o valor do banco ao total
        $total_banco += floatval($row['valor_banco']);
    }

    // Adiciona a linha com o valor total no banco
    echo '<tr>';
    echo '<td colspan="3"><b>Total nos Bancos:</b></td>';
    echo '<td>' . escape_for_excel(number_format($total_banco, 2, ',', '.')) . '</td>';
    echo '</tr>';

    echo '</table>';
    ?>

</body>
</html>
