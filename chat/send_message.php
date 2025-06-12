<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php'; // Certifique-se de incluir o arquivo de conexão ao banco de dados

$usuarioLogado = $_SESSION["usuario"];
$receiverId = $_POST['receiver_id'];
$message = $_POST['message'];
$username = $_POST['username'];

$file_path = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        $file_path = $targetFilePath;
    }
}

// Definindo o fuso horário para o Brasil
date_default_timezone_set('America/Sao_Paulo');
$horarioBrasileiro = date('Y-m-d H:i:s');

$sql = "INSERT INTO messages (sender_id, receiver_id, message, username, timestamp, file_path) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "iissss", $usuarioLogado, $receiverId, $message, $username, $horarioBrasileiro, $file_path);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'error' => mysqli_stmt_error($stmt)]);
}

?>
