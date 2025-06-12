<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro de Entrada</title>
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
    <h1>Filtro de entrada</h1>

    <form method="GET">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" id="dataInicio" name="dataInicio">

        <label for="dataFim">Data de Fim:</label>
        <input type="date" id="dataFim" name="dataFim">

        <label for="nomeCliente">Cliente:</label>
        <select id="nomeCliente" name="nomeCliente">
            <option value="">Selecione um Cliente</option>
            <?php
            // Conecte-se ao banco de dados
            include_once 'conexao.php';

            // Consulta para obter a lista de clientes
            $query = "SELECT DISTINCT nome FROM entrada WHERE deletado = 'N'";
            $result = mysqli_query($conexao, $query);

            // Verifique se a consulta retornou resultados
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nomeCliente = htmlspecialchars($row['nome']);
                    echo "<option value=\"$nomeCliente\">$nomeCliente</option>";
                }
            }
            // Feche a conexão com o banco de dados
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
        $nomeCliente = isset($_GET['nomeCliente']) ? $_GET['nomeCliente'] : '';

        // Inicializa a cláusula WHERE com o intervalo de datas
        $sql = "SELECT * FROM entrada WHERE data BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";

        // Adiciona o filtro pelo cliente, se fornecido
        if (!empty($nomeCliente)) {
            $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conexao, $nomeCliente) . "%'";
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
                    <th scope="col">ID</th>
                    <th scope="col">R$</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Form Pag</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Data</th>
                    <th scope="col">Banco</th>
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
                        $quantos = $array['quantos'];
                        $descricao = $array['descricao'];
                        $fmpag = $array['fmpag'];
                        $responsavel = $array['responsavel'];
                        $nomeCliente = $array['nome'];
                        $data = $array['data'];
                        $nomeBanco = $array['nomeBanco'];

                        $data_original = $data;
                        $timestamp = strtotime($data_original);
                        $data_formatada = date("d/m/y", $timestamp)
                ?>
                        <tr>
                            <td>
                                <?= $id ?>
                            </td>
                            <td>
                                <?= $quantos ?>
                            </td>
                            <td>
                                <?= $descricao ?>
                            </td>
                            <td>
                                <?= $fmpag ?>
                            </td>
                            <td>
                                <?= $responsavel ?>
                            </td>
                            <td>
                                <?= $nomeCliente ?>
                            </td>
                            <td>
                                <?= $data_formatada ?>
                            </td>
                            <td>
                                <?= $nomeBanco ?>
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
            $sql = "SELECT * FROM entrada WHERE data BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";
            $resultado = mysqli_query($conexao, $sql);

            // Inicializa o total
            $total = 0;

            // Verifica se há resultados
            if (mysqli_num_rows($resultado) > 0) {
                // Loop para processar os resultados e somar o total
                while ($array = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                    $total += $array['quantos'];
                }

                // Exibe o resultado na tela
                echo '<span style="color: black;"><br><b> O total de entrada (receita) no intervalo de datas é:</span><span style="color: Blue;"> R$:' . number_format($total, 2, ',', '') . '</b></span>';
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