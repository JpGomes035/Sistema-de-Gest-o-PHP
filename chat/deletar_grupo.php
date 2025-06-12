<?php
include '../conexao.php';
session_start();

header('Content-Type: application/json');

if (!isset($_POST['group_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do grupo não fornecido']);
    exit;
}

$groupId = (int) $_POST['group_id'];
$usuarioLogado = $_SESSION['usuario'] ?? null;

if (!$usuarioLogado) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não logado']);
    exit;
}

// Verifica se o usuário é membro do grupo (opcional)
$queryCheck = "SELECT * FROM grupo_membros WHERE id_grupo = $groupId AND id_usuario = $usuarioLogado";
$resultCheck = mysqli_query($conexao, $queryCheck);

if (mysqli_num_rows($resultCheck) === 0) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Sem permissão para deletar']);
    exit;
}

// Realiza soft delete
$query = "UPDATE grupos SET deletado = 's' WHERE id = $groupId";

if (mysqli_query($conexao, $query)) {
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => mysqli_error($conexao)]);
}
