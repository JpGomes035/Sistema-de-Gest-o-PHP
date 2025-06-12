<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processando destino</title>
    <style>
    body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
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
</style>
</head>
<body>
<?php
include_once 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se todos os campos necessários foram enviados
    if (isset($_POST['codigo_pedido']) && isset($_POST['destino']) && isset($_POST['valor_total'])) {
        // Obtém os dados do formulário
        $codigo_pedido = $_POST['codigo_pedido'];
        $destino = $_POST['destino'];
        $valor_total_pedido = $_POST['valor_total'];

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Consulta SQL para obter o valor atual do campo valor_banco do banco selecionado
        $sql_select = "SELECT valor_banco FROM banco WHERE nomeBanco = '$destino'";
        $result = $conexao->query($sql_select);

        if ($result->num_rows > 0) {
            // Se houver resultado, obtenha o valor atual do banco de dados
            $row = $result->fetch_assoc();
            $valor_atual_banco = $row["valor_banco"];

            // Calcula o novo valor do banco somando o valor atual com o valor do pedido
            $novo_valor_banco = $valor_atual_banco + $valor_total_pedido;

            // Atualiza o valor_banco na tabela banco com o novo valor apenas para o banco selecionado
            $sql_update = "UPDATE banco SET valor_banco = $novo_valor_banco WHERE nomeBanco = '$destino'";
            if ($conexao->query($sql_update) === TRUE) {
                // Aqui você adiciona o comando para marcar o pedido como pago
                $sql_update_pedido = "UPDATE pedidos SET `pago` = 'S' WHERE `codigo_pedido` = $codigo_pedido";
                if ($conexao->query($sql_update_pedido) === TRUE) {
                    echo "Valor total do pedido adicionado ao valor do banco '$destino' com sucesso. Pedido marcado como Recebido.";
                } else {
                    echo "Erro ao marcar o pedido como pago: " . $conexao->error;
                }
            } else {
                echo "Erro ao executar a atualização: " . $conexao->error;
            }
        } else {
            echo "Erro ao obter o valor atual do banco de dados.";
        }

        // Fecha a conexão com o banco de dados
        $conexao->close();
    } else {
        // Se algum campo estiver faltando, exibe uma mensagem de erro
        echo "Erro: Todos os campos são obrigatórios.";
    }
} else {
    // Se o método de requisição não for POST, exibe uma mensagem de erro
    echo "Erro: Este arquivo só pode ser acessado através do envio de formulário.";
}
?>
<a href="lista_pedidos.php">Voltar</a>
</body>
</html>
