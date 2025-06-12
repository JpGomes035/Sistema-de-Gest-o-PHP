<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';


// Configurações de paginação
$registrosPorPagina = 1000000;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Consulta SQL padrão sem filtro de pesquisa
$sql = "SELECT IdProduto, Categoria, Fornecedor, Nome, Numero, Quantidade, precovenda FROM `estoque` where deletado = 'N'";

// Verifica se foi enviado um termo de pesquisa
if (isset($_GET['termo'])) {
    $termo = $_GET['termo'];

    // Adiciona a cláusula WHERE à consulta SQL para buscar produtos que correspondam ao termo de pesquisa
    $sql .= " WHERE Nome LIKE '%$termo%' OR Categoria LIKE '%$termo%' OR Fornecedor LIKE '%$termo%' OR Numero LIKE '%$termo%'";
}

// Adiciona a cláusula LIMIT e OFFSET à consulta SQL
$sql .= " LIMIT $registrosPorPagina OFFSET $offset";

$retorno = mysqli_query($conexao, $sql);

$produtosArray = array();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="print_produtos.css" media="print">
<title>Valor estoque</title>

<head>
    <style>
        .chart {
            width: 300px;
            height: 60px;
            border: 1px solid #ccc;
            margin: 20px;
            padding: 10px;
            display: flex;
            align-items: center;
            position: relative;
        }

        th,
        tr,
        td {
            text-align: center;
        }

        .bar {
            background-color: #4CAF50;
            height: 100%;
            width: 200%;
            transition: width 0.5s;
        }

        .icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: black;
        }

        .label {
            margin-left: 30px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        th,
        td {
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        th {
            background-color: grey;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
        }


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
        }

        a {
            color: red;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: black;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: black;
            font-weight: bold;
        }

        h7 {
            font-weight: bold;
        }
        @media print {
            #menu,
            a
            {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <?php include_once 'menu.php'; ?>
    <div style="padding:20px 0" class="container">
        <h4>Relatório valor estoque</h4>
        <p>Esse Relatório foi criado para mostrar o valor $ que tem dentro do seu estoque em produtos. Facilitando assim
            a verificação<br>
            Foi utilizado o cálculo de (preço de venda * quantidade) de cada item cadastrado no sistema.
        </p>
        <table class="table">
            <div class="print-content">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Nº Produto</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Fornecedor</th>
                        <th scope="col">Preço venda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                        $produtosArray[] = $array;
                        $idProduto = $array['IdProduto'];
                        $categoria = $array['Categoria'];
                        $fornecedor = $array['Fornecedor'];
                        $nome = $array['Nome'];
                        $numero = $array['Numero'];
                        $quantidade = $array['Quantidade'];
                        $precovenda = $array['precovenda'];
                        ?>
                        <tr>
                            <td>
                                <?= $idProduto ?>
                            </td>
                            <td>
                                <?= $nome ?>
                            </td>
                            <td>
                                <?= $numero ?>
                            </td>
                            <td>
                                <?= $categoria ?>
                            </td>
                            <td>
                                <?= $quantidade ?>
                            </td>
                            <td>
                                <?= $fornecedor ?>
                            </td>
                            <td>R$
                                <?= $precovenda ?>
                            </td>

                        <?php } ?>
                    </tr>

                </tbody>
        </table>

        <?php
        $estoqueTotal = 0;

        // Itera sobre o array de produtos para calcular o valor total
        foreach ($produtosArray as $produto) {
            // Certifique-se de que as chaves 'Quantidade' e 'precovenda' existam no array
            if (isset($produto['Quantidade'], $produto['precovenda'])) {
                // Obtém a quantidade e o preço de venda do produto
                $quantidade = $produto['Quantidade'];
                $precovenda = $produto['precovenda'];

                // Calcula o valor total para o produto e adiciona ao estoque total
                $valorProduto = $quantidade * $precovenda;
                $estoqueTotal += $valorProduto;
            }
        }

        
        
        // O resultado final estará em $estoqueTotal
        $estoqueTotalFormatado = number_format($estoqueTotal, 2, ',', '.'); // Formata o valor com 2 casas decimais, vírgula como separador decimal e ponto como separador de milhares
        
        echo '<span style="color: Black;"><b>O valor total no estoque é: </span><span style="color: blue;">R$' . $estoqueTotalFormatado . '</b></span>';

        
        ?>



        <?php
        // Consulta SQL para contar o total de registros
        $sqlTotalRegistros = "SELECT COUNT(*) AS total FROM `estoque` where deletado = 'N'";
        $resultadoTotalRegistros = mysqli_query($conexao, $sqlTotalRegistros);
        $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];

        // Calcula o total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        // Exibe a paginação
        echo '<ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo '<li class="page-item ' . ($paginaAtual == $i ? 'active' : '') . '">';
            echo '<a class="page-link" href="?pagina=' . $i . '">' . $i . '</a>';
            echo '</li>';
        }
        echo '</ul>';
        ?>

        <!--<button class="imprimir" onclick="imprimirProdutos()">Gerar Relatório</button>-->
        <br><br>
        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                    Produto <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                    Produto <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        if (isset($_GET['cadastrado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                    Produto cadastrado com sucesso!.
                </div>';
        }
        ?>
        <a href="relatorios.php">Voltar</a>
    </div>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function () {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);

        function imprimirProdutos() {
            window.print();
        }
    </script>    
</body>

</html>