<?php
// Inclua o arquivo de conexão com o banco de dados
include_once 'conexao.php';

// Obtenha os valores do formulário
$id = $_POST['id'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$ano = $_POST['ano'];
$cor = $_POST['cor'];
$placa = $_POST['placa'];
$quilometragem = $_POST['quilometragem'];
$condicao = $_POST['condicao'];

// Atualize os dados no banco de dados
$sql = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano', cor = '$cor', placa = '$placa', quilometragem  = '$quilometragem ', condicao = '$condicao' WHERE id = $id";
$update = mysqli_query($conexao, $sql);

// Verifique se a atualização foi bem-sucedida
if ($update) {
    header("Location: listar_veiculos.php?atualizado=" . $id);
    exit();
} else {
    // Trate qualquer erro que possa ocorrer durante a atualização
    echo "Erro ao atualizar os dados do veículo: " . mysqli_error($conexao);
}

// Feche a conexão com o banco de dados, se necessário
mysqli_close($conexao);
?>
