<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Contas a Receber</title>
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
    <h1>Filtro de Contas a receber (Data de vencimento)</h1>

    <form method="GET">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" id="dataInicio" name="dataInicio">

        <label for="dataFim">Data de Fim:</label>
        <input type="date" id="dataFim" name="dataFim">

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

        // Query SQL para buscar registros no intervalo de datas
        $sql = "SELECT * FROM contas_receber WHERE data_vencimento BETWEEN '$dataInicio' AND '$dataFim' AND status = 'N'";
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
                    <th scope="col">ID</th>
                    <th scope="col">Nº Doc</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">V.Parcela</th>
                    <th scope="col">V.Venda</th>
                    <th scope="col">Data de Vencimento</th>
                    <th scope="col">Data da Venda</th>
                    <th scope="col">Cliente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se a consulta foi bem-sucedida
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para processar os resultados
                    while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                        // Aqui você pode fazer o que desejar com os resultados
                        $id_Contasreceber = $array['id_Contasreceber'];
                        $numero_documento = $array['numero_documento'];
                        $descricao_venda = $array['descricao_venda'];
                        $valor_parcela = $array['valor_parcela'];
                        $valor_venda = $array['valor_venda'];
                        $data_vencimento = $array['data_vencimento'];
                        $data_venda = $array['data_venda'];
                        $cliente = $array['cliente'];

                        $datavenda_original = $data_venda;
                        $timestamp = strtotime($datavenda_original);
                        $data_formatada_venda = date("d/m/y", $timestamp);

                        $data_vencimento_original = $data_vencimento;
                        $timestamp = strtotime($data_vencimento_original);
                        $data_formatada_receber = date("d/m/y", $timestamp)

                            ?>
                        <tr>
                            <td>
                                <?= $id_Contasreceber ?>
                            </td>
                            <td>
                                <?= $numero_documento ?>
                            </td>
                            <td>
                                <?= $descricao_venda ?>
                            </td>
                            <td>
                                <?= $valor_parcela ?>
                            </td>
                            <td>
                                <?= $valor_venda ?>
                            </td>
                            <td>
                                <?= $data_formatada_receber ?>
                            </td>
                            <td>
                                <?= $data_formatada_venda ?>
                            </td>
                            <td>
                                <?= $cliente ?>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "Por favor, selecione uma data de início e uma data de fim.";
                }
                ?>
            </tbody>
        </table>
        <?php

        include_once 'conexao.php';

        // Verificar se o formulário foi enviado
        if (isset($_GET['dataInicio']) && isset($_GET['dataFim'])) {
            $dataInicio = $_GET['dataInicio'];
            $dataFim = $_GET['dataFim'];

            // Query SQL para buscar registros no intervalo de datas
            $sql = "SELECT * FROM contas_receber WHERE data_vencimento BETWEEN '$dataInicio' AND '$dataFim' AND status = 'N'";
            $resultado = mysqli_query($conexao, $sql);

            // Inicializa o total
            $total = 0;

            // Verifica se há resultados
            if (mysqli_num_rows($resultado) > 0) {
                // Loop para processar os resultados e somar o total
                while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                    $total += $array['valor_parcela'];
                }

                // Exibe o resultado na tela
                echo '<span style="color: black;"><br> <b>O total para Receber no intervalo de datas é:</span><span style="color: blue;"> R$:' . number_format($total, 2, ',', '') . '</b></span>';
            } else {
                // Se não houver registros no intervalo de datas
                echo '<span style="color: black;">Nenhum registro encontrado no intervalo de datas. </span>';
            }

        } else {
            // Se as datas não foram fornecidas
            echo "Por favor, selecione uma data de início e uma data de fim.";
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conexao);
        ?>
    </div>
    <br>
    <b><a href="relatorios.php">Voltar</a>
        <br></b>
</body>

</html>