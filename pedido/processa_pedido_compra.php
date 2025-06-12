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
        $nome_fornecedor = $_POST["nome_fornecedor"];
        $responsavel_pedido = $_POST["responsavel_pedido"];
        $observacoes = $_POST["observacoes"];
        $produtos = $_POST["produtos"];
        $quantidades = $_POST["quantidades"];
        $valores_unitarios = $_POST["valor_unitario"];
        $valor_total = $_POST["valor_total"];
        $data = $_POST["data"];
        $fm_pag = $_POST["fm_pag"];
        $banco_receb = $_POST["banco_receb"];

        $stmt_qtd_atual = null; // Inicializa a variável fora do condicional
        // Verifica se o checkbox "Descontar do Estoque" está marcado
        $somar_estoque = isset($_POST["somar_estoque"]) ? 1 : 0;

        $adicionar_valor = isset($_POST['adicionar_valor']) && $_POST['adicionar_valor'] == 1;

        // Define o valor do campo 'pago' com base na seleção do checkbox
        $pago = $adicionar_valor ? 'S' : 'N';

        // Inicia uma transação
        $conexao->begin_transaction();

        // Prepara a query de inserção no banco de dados
        $stmt = $conexao->prepare("INSERT INTO pedido_compra (nome_fornecedor, responsavel_pedido, fm_pag, banco_receb, observacoes, valor_total, data, deletado, id_reg_delet, pago) VALUES (?, ?, ?, ?, ?, ?, ?, 'N', '0', ?)");
        $stmt->bind_param("sssssdss", $nome_fornecedor, $responsavel_pedido, $fm_pag, $banco_receb, $observacoes, $valor_total, $data, $pago);
        $stmt->execute();
        $codigo_pedido = $stmt->insert_id;


        // Loop para inserir cada produto
        for ($i = 0; $i < count($produtos); $i++) {
            $produto_id = $produtos[$i];
            $quantidade = $quantidades[$i];
            $valor_unitario = floatval($valores_unitarios[$i]); // Converte para float

            // Consulta o nome do produto na tabela estoque com base no ID do produto
            $sql_produto = "SELECT Nome FROM estoque WHERE IdProduto = ?";
            $stmt_produto = $conexao->prepare($sql_produto);
            $stmt_produto->bind_param("i", $produto_id);
            $stmt_produto->execute();
            $result_produto = $stmt_produto->get_result();
            $row_produto = $result_produto->fetch_assoc();
            $nome_produto = $row_produto['Nome'];

            // Prepara e executa a query de inserção dos itens do pedido
            $stmt_itens = $conexao->prepare("INSERT INTO itens_pedido_compra (codigo_pedido, produto_id, nome_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?, ?)");
            $stmt_itens->bind_param("iisid", $codigo_pedido, $produto_id, $nome_produto, $quantidade, $valor_unitario);
            $stmt_itens->execute();

            // Atualiza o campo preco_custo com o valor_unitario
            $stmt_atualiza_preco = $conexao->prepare("UPDATE estoque SET preco_custo = ? WHERE IdProduto = ?");
            $stmt_atualiza_preco->bind_param("di", $valor_unitario, $produto_id);
            $stmt_atualiza_preco->execute();

            // Soma ao estoque se a opção estiver marcada
            if ($somar_estoque) {
                // Consulta a quantidade atual em estoque do produto
                $sql_qtd_atual = "SELECT Quantidade FROM estoque WHERE IdProduto = ?";
                $stmt_qtd_atual = $conexao->prepare($sql_qtd_atual);
                $stmt_qtd_atual->bind_param("i", $produto_id);
                $stmt_qtd_atual->execute();
                $result_qtd_atual = $stmt_qtd_atual->get_result();
                $row_qtd_atual = $result_qtd_atual->fetch_assoc();
                $quantidade_atual = $row_qtd_atual['Quantidade'];

                // Soma a quantidade atual com a quantidade do pedido
                $nova_quantidade = $quantidade_atual + $quantidade;

                // Atualiza a quantidade em estoque
                $stmt_atualiza_estoque = $conexao->prepare("UPDATE estoque SET Quantidade = ? WHERE IdProduto = ?");
                $stmt_atualiza_estoque->bind_param("ii", $nova_quantidade, $produto_id);
                $stmt_atualiza_estoque->execute();
            }
        }


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
            $message = "Prezado $responsavel_pedido,\n\nSeu pedido de compra #$codigo_pedido foi processado com sucesso.\n\n";
            $message .= "Fornecedor: $nome_fornecedor\n";
            $message .= "Valor Total: R$ $valor_total\n";
            $message .= "Data: $data\n\n";
            $message .= "Forma de Pagamento: $fm_pag\n\n";
            $message .= "Observações: $observacoes\n\n";
            $headers = "From: no-reply@gmail.com\r\n";

            // Envia o e-mail
            if (mail($email_responsavel, $subject, $message, $headers)) {
                echo "<h2>Pedido inserido com sucesso! Um e-mail de confirmação foi enviado para $email_responsavel.<br> Verifique também a caixa de SPAM. Aguarde!!</h2>";
            } else {
                echo "<h2>Pedido inserido com sucesso, mas ocorreu um erro ao enviar o e-mail de confirmação.</h2>";
                error_log("Erro ao enviar e-mail para: $email_responsavel"); // Registra o erro no log do servidor
            }

            // Verifica se o valor total deve ser adicionado ao banco
            if ($adicionar_valor) {
                // Atualiza o saldo do banco escolhido
                $sql_atualizar_banco = "UPDATE banco SET valor_banco = valor_banco - ? WHERE nomeBanco = ?";
                $stmt_atualizar_banco = $conexao->prepare($sql_atualizar_banco);
                $stmt_atualizar_banco->bind_param("ds", $valor_total, $banco_receb); // d = double (para valor_total), s = string (para banco_receb)
                $stmt_atualizar_banco->execute();
                $stmt_atualizar_banco->close();

                echo "<h2>Valor total adicionado ao banco $banco_receb com sucesso!</h2>";
            }

            // Redireciona após 5 segundos
            echo "<script>
                setTimeout(function() {
                    window.location.href = '../lista_pedido_compras.php';
                }, 5000); // 5000 milissegundos = 5 segundos
            </script>";
        } else {
            echo "<h2>Ocorreu um erro ao inserir o pedido.</h2>";
            $conexao->rollback(); // Desfaz as alterações em caso de erro
        }

        // Fecha os statements
        $stmt->close();
        $stmt_produto->close();
        $stmt_email->close();

        // Fecha a conexão
        $conexao->close();
    } else {
        header("Location: pedido.php");
    }
    ?>
</body>

</html>