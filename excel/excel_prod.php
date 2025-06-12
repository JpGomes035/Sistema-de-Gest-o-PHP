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
            border: 1px solid #000;
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

    include_once '../iniciar_sessao.php';
    include_once '../conexao.php';
    // função para escapar caracteres especiais em uma string para uso em uma célula do Excel
    function escape_for_excel($string)
    {
        // Escape de aspas duplas
        $string = str_replace('"', '""', $string);
        return $string;
    }

    // Cabeçalho para forçar o download de um arquivo Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=relatorio_produtos.xls");

    // Consulta SQL para obter os dados do relatório
    $sql = "SELECT IdProduto, Categoria, Fornecedor, Nome, Numero, Quantidade, precovenda, qntVendas, preco_custo, preco_bruto, precoPromocional, catalogo, promocao  FROM `estoque` where deletado = 'N' ORDER BY qntVendas DESC";
    $resultado = mysqli_query($conexao, $sql);

    // Inicializar a saída do Excel
    echo '<table>';
    echo '<tr><th>ID</th><th>Nome</th><th>Numero Produto</th><th>Categoria</th><th>Quantidade</th><th>Fornecedor</th><th>Preco venda</th><th>Qnt_Vendas</th><th>Preco Custo</th><th>Preco Bruto</th><th>Preco Promocional</th> <th>Catalogo </th><th>Promocao </th></tr>';

    /// Loop pelos resultados e imprimir cada linha no arquivo Excel
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo '<tr>';
        echo '<td>' . (escape_for_excel($row['IdProduto']) ? escape_for_excel($row['IdProduto']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['Nome']) ? escape_for_excel($row['Nome']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['Numero']) ? escape_for_excel($row['Numero']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['Categoria']) ? escape_for_excel($row['Categoria']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['Quantidade']) ? escape_for_excel($row['Quantidade']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['Fornecedor']) ? escape_for_excel($row['Fornecedor']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['precovenda']) ? escape_for_excel($row['precovenda']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['qntVendas']) ? escape_for_excel($row['qntVendas']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['preco_custo']) ? escape_for_excel($row['preco_custo']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['preco_bruto']) ? escape_for_excel($row['preco_bruto']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['precoPromocional']) ? escape_for_excel($row['precoPromocional']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['catalogo']) ? escape_for_excel($row['catalogo']) : 'no registry') . '</td>';
        echo '<td>' . (escape_for_excel($row['promocao']) ? escape_for_excel($row['promocao']) : 'no registry') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    ?>
</body>

</html>