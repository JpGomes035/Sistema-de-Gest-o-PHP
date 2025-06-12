<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php';

$groupId = $_GET['group_id'] ?? 0;

if (!$groupId) {
    echo json_encode(['error' => 'Parâmetro group_id ausente']);
    exit;
}

// Usando prepared statements para segurança
$stmt = $conexao->prepare(query: "SELECT mg.*, u.Nome AS username 
                           FROM messages_group mg
                           JOIN usuario u ON mg.sender_id = u.IdUsuario
                           WHERE mg.id_grupo = ?
                           ORDER BY mg.timestamp ASC");

$stmt->bind_param("i", $groupId);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
