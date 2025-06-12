<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


// Obtenha os valores do formulário
$idCliente = trim($_POST["idCliente"]);
$respCliente = trim($_POST["respCliente"]);

// Atualize os dados no banco de dados
$sql = "UPDATE cliente SET respCliente = '$respCliente' WHERE idCliente = $idCliente";
$update = mysqli_query($conexao, $sql);

// Verifique se a atualização foi bem-sucedida
if ($update) {
    header("Location: listar_cliente.php?atualizado=" . $idCliente);
    exit();
} else {
    // Trate qualquer erro que possa ocorrer durante a atualização
    echo "Erro ao atualizar os dados do cliente: " . mysqli_error($conexao);
}

// Feche a conexão com o banco de dados, se necessário
mysqli_close($conexao);
?>
