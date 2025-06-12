<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php'; // Arquivo de conexão com o banco de dados

// Busca setores
$sql = "SELECT idSetor, NomeSetor FROM setor";
$result = $conexao->query($sql);

$setores = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $setores[] = $row;
    }
}

$conexao->close();

echo json_encode($setores);
?>