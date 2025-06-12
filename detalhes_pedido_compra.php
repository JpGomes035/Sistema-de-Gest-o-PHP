<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<?php
// Verifica se o código do pedido foi recebido via parâmetro de URL
if (isset($_GET['codigo_pedido'])) {
    include_once 'conexao.php';

    // Obtém o código do pedido da URL
    $codigo_pedido = $_GET['codigo_pedido'];

    // Consulta os detalhes do pedido com base no código do pedido
    $sql_pedido = "SELECT * FROM pedido_compra WHERE codigo_pedido = $codigo_pedido";
    $result_pedido = $conexao->query($sql_pedido);

    if ($result_pedido->num_rows > 0) {
        // Exibe os detalhes do pedido
        while ($row_pedido = $result_pedido->fetch_assoc()) {
            $nome_fornecedor = $row_pedido["nome_fornecedor"];
            $data = $row_pedido["data"];
            $valor_total = $row_pedido["valor_total"];
            $responsavel_pedido = $row_pedido["responsavel_pedido"];
            $observacoes = $row_pedido["observacoes"];
            $fm_pag = $row_pedido["fm_pag"];
            $banco_receb = $row_pedido["banco_receb"];

            // Exibe o cabeçalho do comprovante
?>

            <?php
            // Consulta SQL para obter todas as informações do fornecedor com base no nome do fornecedor
            $sql_fornecedor = "SELECT * FROM fornecedor WHERE nomeForn = '$nome_fornecedor'";
            $result_fornecedor = $conexao->query($sql_fornecedor);

            if ($result_fornecedor->num_rows > 0) {
                // Exibe os detalhes do fornecedor
                while ($row_fornecedor = $result_fornecedor->fetch_assoc()) {
                    // Aqui você pode acessar os detalhes do fornecedor, por exemplo:
                    $IdFornecedor = $row_fornecedor["IdFornecedor"];
                    $cnpjForn = $row_fornecedor["cnpjForn"];
                    // Faça o que precisar com essas informações
                }
            } else {
                // Caso não haja fornecedor com o nome fornecido
                echo "Nenhum fornecedor encontrado com o nome fornecido: $nome_fornecedor";
            }



            ?>
            <!DOCTYPE html>
            <html lang="pt-BR">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Comprovante</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }

                    td {
                        font-weight: bold;
                    }

                    .container1 {
                        max-width: 900px;
                        margin: 20px auto;
                        padding: 20px;
                        border: 2px solid black;
                    }

                    .header {
                        max-width: 100%;
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .title {
                        font-size: 24px;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }

                    .titleee {
                        font-size: 16px;
                        font-weight: bold;
                        margin-bottom: 7px;
                    }


                    .subtitle {
                        font-size: 14px;
                        margin-bottom: 12px;
                        font-weight: bold;
                        text-align: left;
                    }

                    .cliente {
                        font-size: 14px;
                        margin-top: -5px;
                        /* Ajuste esse valor conforme necessário */
                        margin-bottom: 12px;
                        font-weight: bold;
                        text-align: right;
                    }

                    .retangulo {
                        max-width: 200px;
                        margin: 20px auto;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        padding: 10px;
                        text-align: left;
                    }

                    .retangulo img {
                        max-width: 100%;
                        height: auto;
                    }

                    h4 {
                        text-align: center;
                    }

                    .details {
                        margin-bottom: 20px;
                    }

                    .details table {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    .details th,
                    .details td {
                        padding: 8px;
                        border-bottom: 1px solid #ccc;
                    }

                    .details th {
                        text-align: center;
                    }

                    .details td {
                        text-align: center;
                    }

                    p {
                        text-align: left;
                        font-size: 14px;
                    }

                    .total {
                        text-align: right;
                        font-weight: bold;
                    }

                    @media print {
                        .no-print {
                            display: none;
                        }
                    }

                    .print-button {
                        padding: 10px 20px;
                        background-color: #4CAF50;
                        color: #fff;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }

                    .print-button:hover {
                        background-color: #45a049;
                    }

                    .valor-total {
                        font-weight: bold;
                        font-size: 16px;
                        color: #333;
                        text-align: right;
                        /* Adicione aqui outras propriedades de estilo conforme necessário */
                    }
                </style>
            </head>

            <body>

                <?php
                include_once 'conexao.php';

                // Consulta SQL para buscar as informações da empresa
                $sql4 = "SELECT nome, cnpj, email, telefone, imagemempresa FROM informacoes";
                $retorno = mysqli_query($conexao, $sql4);
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $nome = $array['nome'];
                    $cnpj = $array['cnpj'];
                    $email = $array['email'];
                    $telefone = $array['telefone'];
                }
                ?>
                <div class="container1">
                    <div class="retangulo">
                        <?php
                        // Consulta SQL para buscar a imagem da empresa
                        $sql = "SELECT imagemempresa FROM informacoes";
                        $resultado = mysqli_query($conexao, $sql);

                        if (mysqli_num_rows($resultado) > 0) {
                            $row = mysqli_fetch_assoc($resultado);
                            $imagemempresa = $row['imagemempresa'];

                            $logo_atual = !empty($imagemempresa) ? $imagemempresa : 'upload-logo/default.jpg';
                            echo '<img src="' . $logo_atual . '" alt="Logo da Empresa" class="logo" ondblclick="ampliarImagem(this)">';
                        } else {
                            echo "Nenhuma imagem encontrada.";
                        }
                        ?>
                    </div>
                    <h4>Pedido de Compra
                        <?php echo "#" . $codigo_pedido; ?>
                    </h4>
                    <div class="header">
                        <br>
                        <div class="subtitle">Empresa:
                            <?php echo $nome; ?>
                        </div>
                        <div class="subtitle">Documento:
                            <?php echo $cnpj; ?>
                        </div>
                        <div class="subtitle">Email:
                            <?php echo $email; ?>
                        </div>
                        <div class="subtitle">Telefone:
                            <?php echo $telefone; ?>
                        </div>
                        <b>
                            <p>------------</p>
                        </b>
                        <div class="header">



                            <p><b>Data de Emissão:
                                    <?php
                                    $data_emissao_original = $data;
                                    $timestamp = strtotime($data_emissao_original);
                                    $data_emissao_formatada = date("d/m/y", $timestamp);
                                    echo $data_emissao_formatada; ?>
                                </b></p>
                            <p><b>Fornecedor:
                                    <?php echo $nome_fornecedor; ?>
                                </b></p>
                            <p><b>Documento:
                                    <?php
                                    if (empty($cnpjForn)) {
                                        echo "Não informado no cadastro.";
                                    } else {
                                        echo $cnpjForn;
                                    }
                                    ?>
                                </b></p>
                            <p><b>Forma Pag:
                                    <?php
                                    if (empty($fm_pag)) {
                                        echo "Não informado";
                                    } else {
                                        echo $fm_pag;
                                    }
                                    ?>
                                </b></p>
                            <p><b>Responsável:
                                    <?php echo $responsavel_pedido; ?>
                                </b></p>

                        </div>
                        <div class="details">
                            <h4>Itens do Pedido:</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Quantidade</th>
                                        <th>Valor unitário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Consulta os itens do pedido com base no código do pedido
                                    $sql_itens = "SELECT produto_id, nome_produto, quantidade, valor_unitario FROM itens_pedido_compra WHERE codigo_pedido = $codigo_pedido";
                                    $result_itens = $conexao->query($sql_itens);

                                    if ($result_itens->num_rows > 0) {
                                        // Exibe os itens do pedido
                                        while ($row_itens = $result_itens->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row_itens["produto_id"] . "</td>";
                                            echo "<td>" . $row_itens["nome_produto"] . "</td>";
                                            echo "<td>" . $row_itens["quantidade"] . "</td>";
                                            echo "<td>" . $row_itens["valor_unitario"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>Nenhum item encontrado.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br>
                            <p><b>Observação:
                                    <?php echo $observacoes; ?>
                                </b></p>
                            <p class="valor-total"><b>Valor Total: R$
                                    <?php echo $valor_total; ?>
                                </b></p>


                        </div>
                    </div>
            </body>

            </html>
<?php
        }
    } else {
        echo "Nenhum pedido encontrado.";
    }
} else {
    echo "Código do pedido não fornecido.";
}
?>