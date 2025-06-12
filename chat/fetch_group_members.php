<?php
header('Content-Type: application/json');
include '../conexao.php';
session_start();

$groupId = $_GET['group_id'] ?? 0;

if (!$groupId) {
    echo json_encode([]);
    exit;
}

// Pega os membros do grupo
$query = "
    SELECT u.IdUsuario, u.Nome, u.Email, u.Imagem
    FROM usuario u
    JOIN grupo_membros gm ON gm.id_usuario = u.IdUsuario
    WHERE gm.id_grupo = $groupId
";

$result = mysqli_query($conexao, $query);

$members = [];

while ($row = mysqli_fetch_assoc($result)) {
    $members[] = [
        'id' => $row['IdUsuario'],
        'nome' => $row['Nome'],
        'email' => $row['Email'],
        'imagem' => $row['Imagem'] ?: 'default-user.png'
    ];
}

echo json_encode($members);
