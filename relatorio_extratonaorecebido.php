<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Extrato (Pagos/Recebidos)</title>
    <style>
            
        body {
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 2px solid #000;
        }

        th {
            background-color: grey;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
        }

        a {
            color: red;
        }

        a:hover {
            color: red;
        }

        .registro {
            margin-bottom: 10px;
        }

        @media print {

            #menu,
            a {
                display: none !important;
            }
        }

    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Extrato - Pedidos Pagos e Recebidos</title>
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
    <h1>Relatório de Extrato - Pedidos De compra/venda não recebidos</h1>

    <form method="GET">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" id="dataInicio" name="dataInicio" required>

        <label for="dataFim">Data de Fim:</label>
        <input type="date" id="dataFim" name="dataFim" required>

        <label for="nome_fornecedor_cliente">Fornecedor/Cliente:</label>
        <input type="text" id="nome_fornecedor_cliente" name="nome_fornecedor_cliente" placeholder="Digite o nome">

        <label for="banco">Banco:</label>
        <input type="text" id="banco" name="banco" placeholder="Digite o banco">

        <label for="tipoTransacao">Tipo de Transação:</label>
        <select id="tipoTransacao" name="tipoTransacao">
            <option value="todos">Todos</option>
            <option value="pedido_compra">Somente Pedido de Compra</option>
            <option value="pedidos">Somente Pedido de Venda</option>
        </select>

        <button type="submit">Filtrar</button>
        <button type="submit" name="exportar" value="excel">Exportar para Excel</button>
        <a href="relatorios.php"> Voltar</a>
        <br>
        
    </form>

    <?php
    // Sua conexão com o banco de dados
    include_once 'conexao.php';

    // Verificar se o formulário foi enviado
    if (isset($_GET['dataInicio']) && isset($_GET['dataFim'])) {
        $dataInicio = $_GET['dataInicio'];
        $dataFim = $_GET['dataFim'];
        $nome_fornecedor_cliente = isset($_GET['nome_fornecedor_cliente']) ? $_GET['nome_fornecedor_cliente'] : '';
        $banco = isset($_GET['banco']) ? $_GET['banco'] : '';
        $tipoTransacao = isset($_GET['tipoTransacao']) ? $_GET['tipoTransacao'] : 'todos';

        // Query para buscar os pedidos de venda (recebidos)
        $sqlPedidos = "SELECT codigo_pedido, nome_cliente AS nome, valor_total, data, fm_pag, banco_receb, 'Venda' AS tipo, pago
                       FROM pedidos 
                       WHERE data BETWEEN '$dataInicio' AND '$dataFim' 
                       AND deletado = 'N' AND pago = 'N'";

        // Query para buscar os pedidos de compra (pagos)
        $sqlCompras = "SELECT codigo_pedido, nome_fornecedor AS nome, valor_total, data, fm_pag, banco_receb, 'Compra' AS tipo, pago 
                       FROM pedido_compra 
                       WHERE data BETWEEN '$dataInicio' AND '$dataFim' 
                       AND deletado = 'N' AND pago = 'N'";

        // Aplicando o filtro de fornecedor/cliente, se preenchido
        if (!empty($nome_fornecedor_cliente)) {
            $sqlPedidos .= " AND nome_cliente LIKE '%" . mysqli_real_escape_string($conexao, $nome_fornecedor_cliente) . "%'";
            $sqlCompras .= " AND nome_fornecedor LIKE '%" . mysqli_real_escape_string($conexao, $nome_fornecedor_cliente) . "%'";
        }

        // Aplicando o filtro de banco, se preenchido
        if (!empty($banco)) {
            $sqlPedidos .= " AND banco_receb LIKE '%" . mysqli_real_escape_string($conexao, $banco) . "%'";
            $sqlCompras .= " AND banco_receb LIKE '%" . mysqli_real_escape_string($conexao, $banco) . "%'";
        }

        // Filtrar pelo tipo de transação (somente compras, somente vendas ou ambos)
        if ($tipoTransacao === 'pedido_compra') {
            $sql = $sqlCompras;
        } elseif ($tipoTransacao === 'pedidos') {
            $sql = $sqlPedidos;
        } else {
            $sql = "($sqlPedidos) UNION ALL ($sqlCompras)";
        }

        $sql .= " ORDER BY data ASC"; // Ordenar por data

        // Executando a consulta
        $resultado = mysqli_query($conexao, $sql);

        // Variável para armazenar o valor total das transações
        $valorTotal = 0;
    }

    // Exportar para Excel se o botão for clicado
    if (isset($_GET['exportar']) && $_GET['exportar'] === 'excel') {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=relatorio_transacoes.xls");

        echo '<table>';
        echo '<tr><th>Código</th><th>Fornecedor/Cliente</th><th>Valor Total</th><th>Data</th><th>Forma de Pagamento</th><th>Banco</th><th>Tipo</th><th>Pago?</th></tr>';

        // Reexecuta a consulta para obter os dados
        $resultado = mysqli_query($conexao, $sql);

        // Loop para processar os resultados e imprimir no arquivo Excel
        while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $array['codigo_pedido'] . '</td>';
            echo '<td>' . $array['nome'] . '</td>';
            echo '<td>' . number_format($array['valor_total'], 2, ',', '.') . '</td>';
            echo '<td>' . date("d/m/Y", strtotime($array['data'])) . '</td>';
            echo '<td>' . ($array['fm_pag'] !== null && $array['fm_pag'] !== "" ? $array['fm_pag'] : "Não informado") . '</td>';
            echo '<td>' . $array['banco_receb'] . '</td>';
            echo '<td>' . $array['tipo'] . '</td>';
            echo '<td>' . ($array['pago'] == 'N' ? 'Não' : 'Sim') . '</td>';
            echo '</tr>';

            // Soma o valor total
            $valorTotal += $array['valor_total'];
        }

        // Linha com o valor total
        echo '<tr>';
        echo '<td colspan="2"><b>Total:</b></td>';
        echo '<td>' . number_format($valorTotal, 2, ',', '.') . '</td>';
        echo '<td colspan="5"></td>'; // Deixa as últimas colunas em branco
        echo '</tr>';

        echo '</table>';
        exit(); // Encerra o script para evitar a renderização HTML adicional
    }
    ?>

    <div class="registro">
        <table>
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Fornecedor/Cliente</th>
                    <th scope="col">Valor Total</th>
                    <th scope="col">Data</th>
                    <th scope="col">Forma de Pagamento</th>
                    <th scope="col">Banco</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Pago?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se a consulta foi bem-sucedida e retornou resultados
                if (isset($resultado) && mysqli_num_rows($resultado) > 0) {
                    // Loop para processar os resultados
                    while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                        $codigo_pedido = $array['codigo_pedido'];
                        $nome = $array['nome'];
                        $valor_total = $array['valor_total'];
                        $data = $array['data'];
                        $fm_pag = $array['fm_pag'];
                        $banco_receb = $array['banco_receb'];
                        $tipo = $array['tipo'];
                        $pago = $array['pago'];


                        $valorTotal += $array['valor_total'];
                        // Imprime a linha da tabela
                        echo '<tr>';
                        echo '<td>' . $codigo_pedido . '</td>';
                        echo '<td>' . $nome . '</td>';
                        echo '<td>' . number_format($valor_total, 2, ',', '.') . '</td>';
                        echo '<td>' . date("d/m/Y", strtotime($data)) . '</td>';
                        echo '<td>' . ($fm_pag !== null && $fm_pag !== "" ? $fm_pag : "Não informado") . '</td>';
                        echo '<td>' . $banco_receb . '</td>';
                        echo '<td>' . $tipo . '</td>';
                        echo '<td>' . ($pago == 'N' ? 'Não' : 'Sim') . '</td>';
                        echo '</tr>';
                    }

                    // Linha com o valor total
                    echo '<tr>';
                    echo '<td colspan="2"><b>Total:</b></td>';
                    echo '<td>' . number_format($valorTotal, 2, ',', '.') . '</td>';
                    echo '<td colspan="5"></td>'; // Deixa as últimas colunas em branco
                    echo '</tr>';
                } else {
                    echo '<tr><td colspan="8">Nenhum registro encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
