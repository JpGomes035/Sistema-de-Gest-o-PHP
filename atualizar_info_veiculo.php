<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';

// Obtenha os valores do formulário
$id = $_POST["id"];
$valor_aquisicao = $_POST["valor_aquisicao"];
$data_aquisicao = $_POST["data_aquisicao"];
$responsavel = $_POST["responsavel"];
$localizacao = $_POST["localizacao"];
$chassi = $_POST["chassi"];

// Atualize os dados no banco de dados
$sql = "UPDATE veiculos SET valor_aquisicao = '$valor_aquisicao', data_aquisicao = '$data_aquisicao', chassi = '$chassi', responsavel = '$responsavel', localizacao = '$localizacao' WHERE id = $id";
$update = mysqli_query($conexao, $sql);

// Verifique se a atualização foi bem-sucedida
if ($update) {
    header("Location: listar_veiculos.php?atualizado=" . $id);
    exit();
} else {
    // Trate qualquer erro que possa ocorrer durante a atualização
    echo "Erro ao atualizar as informações do veículo: " . mysqli_error($conexao);
}

// Feche a conexão com o banco de dados, se necessário
mysqli_close($conexao);
?>
