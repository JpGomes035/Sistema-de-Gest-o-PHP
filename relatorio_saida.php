<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
    <title>Filtro de Saída</title>
    <style>
        body {
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: black;
            font-family: 'Poppins', sans-serif;
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
    <h1>Filtro de Saída</h1>

    <form method="GET">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" id="dataInicio" name="dataInicio">

        <label for="dataFim">Data de Fim:</label>
        <input type="date" id="dataFim" name="dataFim">

        <label for="responsavel">Responsável:</label>
        <select id="responsavel" name="responsavel">
            <option value="">Selecione um Cliente</option>
            <?php
            // Conecte-se ao banco de dados
            include_once 'conexao.php';

            // Consulta para obter a lista de clientes
            $query = "SELECT DISTINCT responsavel FROM saida WHERE deletado = 'N'";
            $result = mysqli_query($conexao, $query);

            // Verifique se a consulta retornou resultados
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $responsavel = htmlspecialchars($row['responsavel']);
                    echo "<option value=\"$responsavel\">$responsavel</option>";
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
        $responsavel = isset($_GET['responsavel']) ? $_GET['responsavel'] : '';

        // Query SQL para buscar registros no intervalo de datas
        $sql = "SELECT * FROM saida WHERE data BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";
        
        if (!empty($responsavel)) {
            $sql .= " AND responsavel LIKE '%" . mysqli_real_escape_string($conexao, $responsavel) . "%'";
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
            $sql = "SELECT * FROM saida WHERE data BETWEEN '$dataInicio' AND '$dataFim' AND deletado = 'N'";
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
                echo '<span style="color: Black;"><b><br> O total de saida (despesa) no intervalo de datas é:</span><span style="color: Red;"> R$:' . number_format($total, 2, ',', '') . '</b></span>';

            } else {
                // Se não houver registros no intervalo de datas
                echo '<span style="color: Black;">Nenhum registro encontrado no intervalo de datas. </span>';
            }

        } else {
            // Se as datas não foram fornecidas
            echo '<span style="color: Black;">Por favor, selecione uma data de início e uma data de fim.</span>';
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