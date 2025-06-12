<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


// Obtenha os valores do formulário
$codigo_pedido = trim($_POST["codigo_pedido"]);
$fm_pag = trim($_POST["fm_pag"]);
$banco_receb = trim($_POST["banco_receb"]);
$valor_total = trim($_POST["valor_total"]);
$responsavel_pedido = trim($_POST["responsavel_pedido"]);
$observacoes = trim($_POST["observacoes"]);

// Atualize os dados no banco de dados
$sql = "UPDATE pedidos SET fm_pag = '$fm_pag', banco_receb = '$banco_receb', observacoes = '$observacoes', valor_total = '$valor_total', responsavel_pedido = '$responsavel_pedido' WHERE codigo_pedido = $codigo_pedido";
$update = mysqli_query($conexao, $sql);

// Verifique se a atualização foi bem-sucedida
if ($update) {
    header("Location: lista_pedidos.php?atualizado=" . $codigo_pedido);
    exit();
} else {
    // Trate qualquer erro que possa ocorrer durante a atualização
    echo "Erro ao atualizar os dados: " . mysqli_error($conexao);
}

// Feche a conexão com o banco de dados, se necessário
mysqli_close($conexao);
?>
