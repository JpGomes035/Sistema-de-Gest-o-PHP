<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$idBoleto = $_GET['id'];
$idUsuarioLogado = $usuarioLogado; // Certifique-se de definir corretamente o valor do usuário logado

$sql = "UPDATE boletos SET deletado = 'S', id_reg_delet = $idUsuarioLogado WHERE id_boleto = $idBoleto";
$update = mysqli_query($conexao, $sql);

if ($update) {
    header("Location: listar_boleto.php?excluido=" . $idBoleto);
} else {
    // Tratar o caso em que a exclusão falha
    echo "Erro na exclusão: " . mysqli_error($conexao);
}
?>
