<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            margin: 0;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once 'conexao.php';

        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }

        $nome_fornecedor = $_POST["nome_fornecedor"];
        $responsavel_pedido = $_POST["responsavel_pedido"];
        $observacoes = $_POST["observacoes"];
        $produtos = $_POST["produtos"];
        $quantidades = $_POST["quantidades"];
        $valores_unitarios = $_POST["valor_unitario"];
        $valor_total = $_POST["valor_total"];
        $data = $_POST["data"];

        $somar_estoque = isset($_POST["somar_estoque"]) ? 1 : 0;

        $conexao->begin_transaction();

        $stmt = $conexao->prepare("INSERT INTO pedido_compra (nome_fornecedor, responsavel_pedido, observacoes, valor_total, data, deletado, id_reg_delet, pago) VALUES (?, ?, ?, ?, ?, 'N', '0', 'N')");
        $stmt->bind_param("sssds", $nome_fornecedor, $responsavel_pedido, $observacoes, $valor_total, $data);
        $stmt->execute();
        $codigo_pedido = $stmt->insert_id;

        for ($i = 0; $i < count($produtos); $i++) {
            $produto_id = $produtos[$i];
            $quantidade = $quantidades[$i];
            $valor_unitario = floatval($valores_unitarios[$i]);

            $sql_produto = "SELECT Nome FROM estoque WHERE IdProduto = ?";
            $stmt_produto = $conexao->prepare($sql_produto);
            $stmt_produto->bind_param("i", $produto_id);
            $stmt_produto->execute();
            $result_produto = $stmt_produto->get_result();
            $row_produto = $result_produto->fetch_assoc();
            $nome_produto = $row_produto['Nome'];

            $stmt_itens = $conexao->prepare("INSERT INTO itens_pedido_compra (codigo_pedido, produto_id, nome_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?, ?)");
            $stmt_itens->bind_param("iisid", $codigo_pedido, $produto_id, $nome_produto, $quantidade, $valor_unitario);
            $stmt_itens->execute();

            if ($somar_estoque) {
                $sql_qtd_atual = "SELECT Quantidade FROM estoque WHERE IdProduto = ?";
                $stmt_qtd_atual = $conexao->prepare($sql_qtd_atual);
                $stmt_qtd_atual->bind_param("i", $produto_id);
                $stmt_qtd_atual->execute();
                $result_qtd_atual = $stmt_qtd_atual->get_result();
                $row_qtd_atual = $result_qtd_atual->fetch_assoc();
                $quantidade_atual = $row_qtd_atual['Quantidade'];

                $nova_quantidade = $quantidade_atual + $quantidade;

                $stmt_atualiza_estoque = $conexao->prepare("UPDATE estoque SET Quantidade = ? WHERE IdProduto = ?");
                $stmt_atualiza_estoque->bind_param("ii", $nova_quantidade, $produto_id);
                $stmt_atualiza_estoque->execute();
            }
        }

        if ($conexao->commit()) {
            echo "<h2>Pedido criado com sucesso!<br> Aguarde!!</h2>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'estoque_baixo.php';
                }, 5000); 
            </script>";
        } else {
            echo "<h2>Ocorreu um erro ao criar o pedido.</h2>";
            $conexao->rollback();
        }

        $stmt->close();
        $stmt_produto->close();
        $conexao->close();
    } else {
        header("Location: estoque_baixo.php");
    }
    ?>
</body>

</html>
