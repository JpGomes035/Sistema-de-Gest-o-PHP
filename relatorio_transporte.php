<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Transporte</title>
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
    <h1>Relatório de Transporte</h1>

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
        $sql = "SELECT * FROM transportes WHERE data_transporte BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";
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
                    <th scope="col">Código Pedido</th>
                    <th scope="col">Tipo de Pedido</th>
                    <th scope="col">V.Transporte</th>
                    <th scope="col">Placa do Veículo</th>
                    <th scope="col">Data de Transporte</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Verificar se a consulta foi bem-sucedida
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para processar os resultados
                    while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                        // Aqui você pode fazer o que desejar com os resultados
                        $id = $array['id'];
                        $pedido_id = $array['pedido_id'];
                        $tipo_pedido = $array['tipo_pedido'];
                        $valor_transporte = $array['valor_transporte'];
                        $veiculo_placa = $array['veiculo_placa'];
                        $data_transporte = date("d/m/Y", strtotime($array['data_transporte']));
                        $status = $array['Concluido'];

                        ?>
                        <tr>
                            <td>
                                <?= $id ?>
                            </td>
                            <td>
                                <?= $pedido_id ?>
                            </td>
                            <td>
                                <?= $tipo_pedido ?>
                            </td>
                            <td>
                                <?= $valor_transporte ?>
                            </td>
                            <td>
                                <?= $veiculo_placa ?>
                            </td>
                            <td>
                                <?= $data_transporte ?>
                            </td>
                            <td>
                                <?= $status ?>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "Nenhum registro encontrado no intervalo de datas.";
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