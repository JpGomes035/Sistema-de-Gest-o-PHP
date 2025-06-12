<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pedidos Venda</title>
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

<body>
    <?php include_once('menu.php'); ?>
    <h1>Filtro de Pedidos de Venda</h1>

    <form method="GET">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" id="dataInicio" name="dataInicio">

        <label for="dataFim">Data de Fim:</label>
        <input type="date" id="dataFim" name="dataFim">

        <label for="nome_cliente">Cliente:</label>
        <select id="nome_cliente" name="nome_cliente">
            <option value="">Selecione um Cliente</option>
            <?php
            // Conecte-se ao banco de dados
            include_once 'conexao.php';

            // Consulta para obter a lista de clientes
            $query = "SELECT DISTINCT nome_cliente FROM pedidos WHERE deletado = 'N'";
            $result = mysqli_query($conexao, $query);

            // Verifique se a consulta retornou resultados
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nome_cliente = htmlspecialchars($row['nome_cliente']);
                    echo "<option value=\"$nome_cliente\">$nome_cliente</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Filtrar</button>
        <br>
    </form>

    <?php
    // Sua conexão com o banco de dados
    include_once 'conexao.php';

    // Verificar se o formulário foi enviado
    if (isset($_GET['dataInicio']) && isset($_GET['dataFim'])) {
        $dataInicio = $_GET['dataInicio'];
        $dataFim = $_GET['dataFim'];
        $nome_cliente = isset($_GET['nome_cliente']) ? $_GET['nome_cliente'] : '';

        // Query SQL para buscar registros no intervalo de datas
        $sql = "SELECT * FROM pedidos WHERE data BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";
        if (!empty($nome_fornecedor)) {
            $sql .= " AND nome_cliente LIKE '%" . mysqli_real_escape_string($conexao, $nome_cliente) . "%'";
        }


        $resultado = mysqli_query($conexao, $sql);

    }
    ?>
    <?php
    echo "Data de Início: " . date("d/m/Y", strtotime($dataInicio)) . "<br>";
    echo "Data de Fim: " . date("d/m/Y", strtotime($dataFim)) . "<br>";
    ?>

    <div class="registro">
        <table>
            <thead>
                <tr>
                    <th scope="col">Cod_pedido</th>
                    <th scope="col">Nome do Cliente</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Valor Total</th>
                    <th scope="col">Data</th>
                    <th scope="col">Form Pag</th>
                    <th scope="col">Recebido?</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se a consulta foi bem-sucedida
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para processar os resultados
                    while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                        // Aqui você pode fazer o que desejar com os resultados
                        $codigo_pedido = $array['codigo_pedido'];
                        $nome_cliente = $array['nome_cliente'];
                        $responsavel_pedido = $array['responsavel_pedido'];
                        $valor_total = $array['valor_total'];
                        $data = $array['data'];
                        $fm_pag = $array['fm_pag'];
                        $pago = $array['pago'];

                        ?>
                        <tr>
                            <td>
                                <?= $codigo_pedido ?>
                            </td>
                            <td>
                                <?= $nome_cliente ?>
                            </td>
                            <td>
                                <?= $responsavel_pedido ?>
                            </td>
                            <td>
                                <?= $valor_total ?>
                            </td>
                            <td>
                                <?php
                                // Recebe a data original e formata para o formato desejado
                                $data_original = $data;
                                $timestamp = strtotime($data_original);
                                $data_formatada = date("d/m/Y", $timestamp);
                                echo $data_formatada;
                                ?>
                            </td>

                            <td>
                                <?= $fm_pag !== null && $fm_pag !== "" ? $fm_pag : "Não informado" ?>
                            </td>

                            <td>
                                <?= $pago == 'S' ? 'Sim' : 'Não' ?>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "Não foram encontrados pedidos no intervalo de datas selecionado.";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br>  
    <b><a href="relatorios.php">Voltar</a>
        <br></b>
</body>

</html>