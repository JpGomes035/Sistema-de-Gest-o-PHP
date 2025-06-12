<?php
include_once '../iniciar_sessao.php';
include_once('../head.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processando</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
            margin: 0;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php
    // Verifica se é uma requisição POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexão com o banco de dados
        include_once '../conexao.php';

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }

        // Recupera os dados do formulário
        $nome_cliente = $_POST["nome_cliente"];
        $responsavel_pedido = $_POST["responsavel_pedido"];
        $observacoes = $_POST["observacoes"];
        $produtos = $_POST["produtos"];
        $quantidades = $_POST["quantidades"];
        $valores_unitarios = $_POST["valor_unitario"];
        $valor_total = $_POST["valor_total"];
        $fm_pag = $_POST["fm_pag"];
        $data = $_POST["data"];
        $banco_receb = $_POST["banco_receb"];

        // Verifica se a opção de descontar do estoque foi marcada
        $descontar_estoque = isset($_POST['descontar_estoque']) && $_POST['descontar_estoque'] == 1;
        $adicionar_valor = isset($_POST['adicionar_valor']) && $_POST['adicionar_valor'] == 1;

        // Define o valor do campo 'pago' com base na seleção do checkbox
        $pago = $adicionar_valor ? 'S' : 'N';

        // Inicia uma transação
        $conexao->begin_transaction();

        // Prepara a query de inserção no banco de dados
        $stmt = $conexao->prepare("INSERT INTO pedidos (nome_cliente, responsavel_pedido, observacoes, valor_total, fm_pag, banco_receb, data, deletado, id_reg_delet, pago) VALUES (?, ?, ?, ?, ?, ?, ?, 'N', '0', ?)");
        $stmt->bind_param("ssssssss", $nome_cliente, $responsavel_pedido, $observacoes, $valor_total, $fm_pag, $banco_receb, $data, $pago);
        $stmt->execute();
        $codigo_pedido = $stmt->insert_id;

        // Loop para inserir cada produto
        for ($i = 0; $i < count($produtos); $i++) {
            $produto_id = $produtos[$i];
            $quantidade = $quantidades[$i];
            $valor_unitario = floatval($valores_unitarios[$i]); // Converte para float

            // Consulta o nome do produto e a quantidade disponível na tabela estoque com base no ID do produto
            $sql_produto = "SELECT Nome, Quantidade, qntVendas FROM estoque WHERE IdProduto = ?";
            $stmt_produto = $conexao->prepare($sql_produto);
            $stmt_produto->bind_param("i", $produto_id);
            $stmt_produto->execute();
            $result_produto = $stmt_produto->get_result();
            $row_produto = $result_produto->fetch_assoc();
            $nome_produto = $row_produto['Nome'];
            $quantidade_disponivel = $row_produto['Quantidade'];
            $qntVendas = $row_produto['qntVendas']; // Quantidade de vendas atual do produto

            // Atualiza a quantidade de vendas do produto
            $qntVendas++; // Incrementa a quantidade de vendas

            // Atualiza a quantidade de vendas na tabela estoque
            $sql_update_vendas = "UPDATE estoque SET qntVendas = ? WHERE IdProduto = ?";
            $stmt_update_vendas = $conexao->prepare($sql_update_vendas);
            $stmt_update_vendas->bind_param("ii", $qntVendas, $produto_id);
            $stmt_update_vendas->execute();
            $stmt_update_vendas->close();

            // Verifica se a quantidade disponível é suficiente para atender ao pedido
            if ($quantidade_disponivel >= $quantidade) {
                // Atualiza a quantidade disponível no estoque se a opção de descontar do estoque estiver marcada
                if ($descontar_estoque) {
                    $quantidade_restante = $quantidade_disponivel - $quantidade;
                    $sql_update_estoque = "UPDATE estoque SET Quantidade = ? WHERE IdProduto = ?";
                    $stmt_update_estoque = $conexao->prepare($sql_update_estoque);
                    $stmt_update_estoque->bind_param("ii", $quantidade_restante, $produto_id);
                    $stmt_update_estoque->execute();
                    $stmt_update_estoque->close();
                }

                // Insere o item do pedido
                $stmt_itens = $conexao->prepare("INSERT INTO itens_pedido (codigo_pedido, produto_id, nome_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?, ?)");
                $stmt_itens->bind_param("iisid", $codigo_pedido, $produto_id, $nome_produto, $quantidade, $valor_unitario);
                $stmt_itens->execute();
                $stmt_itens->close();
            } else {
                // Se a quantidade disponível no estoque não for suficiente, exiba uma mensagem de erro
                echo "<h2>O produto #$produto_id $nome_produto não tem quantidade suficiente em estoque para atender ao pedido, favor verificar estoque de produtos.</h2>";
                echo "<script>
                setTimeout(function() {
                    window.location.href = 'pedido.php';
                }, 5000); // 5000 milissegundos = 5 segundos
              </script>";
                $conexao->rollback(); // Desfaz as alterações em caso de erro
                exit(); // Termina o script
            }
        }



        // Verifica se a inserção foi bem-sucedida
        if ($conexao->commit()) {
            // Recupera o e-mail do responsável pelo pedido
            $sqlEmail = "SELECT Email FROM usuario WHERE Nome = ? AND Status = 'Ativo'";
            $stmt_email = $conexao->prepare($sqlEmail);
            $stmt_email->bind_param("s", $responsavel_pedido);
            $stmt_email->execute();
            $result_email = $stmt_email->get_result();
            $usuario = $result_email->fetch_assoc();
            $email_responsavel = $usuario['Email'];

            // Prepara o conteúdo do e-mail
            $subject = "Confirmação de Pedido #$codigo_pedido";
            $message = "Prezado $responsavel_pedido,\n\nSeu pedido de venda #$codigo_pedido foi processado com sucesso.\n\n";
            $message .= "Cliente: $nome_cliente\n";
            $message .= "Valor Total: R$ $valor_total\n";
            $message .= "Data: $data\n\n";
            $message .= "Forma de Pagamento: $fm_pag\n\n";
            $message .= "Observações: $observacoes\n\n";
            $headers = "From: no-replyvenda@gmail.com";

            // Envia o e-mail
            if (mail($email_responsavel, $subject, $message, $headers)) {
                echo "<h2>Pedido inserido com sucesso! Um e-mail de confirmação foi enviado para $email_responsavel.<br> verificar tambem caixa de SPAM. Aguarde!!</h2>";
            } else {
                echo "<h2>Pedido inserido com sucesso, mas ocorreu um erro ao enviar o e-mail de confirmação.</h2>";
            }

            // Verifica se o valor total deve ser adicionado ao banco
            if ($adicionar_valor) {
                // Atualiza o saldo do banco escolhido
                $sql_atualizar_banco = "UPDATE banco SET valor_banco = valor_banco + ? WHERE nomeBanco = ?";
                $stmt_atualizar_banco = $conexao->prepare($sql_atualizar_banco);
                $stmt_atualizar_banco->bind_param("ds", $valor_total, $banco_receb); // d = double (para valor_total), s = string (para banco_receb)
                $stmt_atualizar_banco->execute();
                $stmt_atualizar_banco->close();

                echo "<h2>Valor total adicionado ao banco $banco_receb com sucesso!</h2>";
            }

            echo "<script>
            setTimeout(function() {
                window.location.href = '../lista_pedidos.php';
            }, 5000); // 2000 milissegundos = 2 segundos
          </script>";
        } else {
            echo "<h2>Ocorreu um erro ao inserir o pedido.</h2>";
            $conexao->rollback(); // Desfaz as alterações em caso de erro
        }

        // Fecha os statements
        if ($stmt !== null) {
            $stmt->close();
        }
        if ($stmt_produto !== null) {
            $stmt_produto->close();
        }
        if ($stmt_email !== null) {
            $stmt_email->close();
        }

        // Fecha a conexão
        $conexao->close();
    } else {
        header("Location: pedido.php");
    }

    ?>
</body>

</html>