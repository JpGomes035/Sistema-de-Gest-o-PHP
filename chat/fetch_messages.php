<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php'; // Certifique-se de incluir o arquivo de conexão ao banco de dados

$usuarioLogado = $_SESSION["usuario"];
$receiverId = $_GET['receiver_id'];

$sql = "SELECT m.*, u.Nome as username 
        FROM messages m 
        JOIN usuario u ON m.sender_id = u.IdUsuario 
        WHERE (sender_id = $usuarioLogado AND receiver_id = $receiverId) 
           OR (sender_id = $receiverId AND receiver_id = $usuarioLogado) 
        ORDER BY m.timestamp DESC";

$retorno = mysqli_query($conexao, $sql);
$messages = [];
while ($row = mysqli_fetch_assoc($retorno)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
