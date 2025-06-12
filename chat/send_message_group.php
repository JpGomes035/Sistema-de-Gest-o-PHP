<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$sender_id = $_SESSION['usuario'];
$id_grupo = $_POST['id_grupo'] ?? null;
$message = trim($_POST['message'] ?? '');

if (!$id_grupo) {
    echo json_encode(['success' => false, 'message' => 'Grupo não especificado']);
    exit;
}

$file_path = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploads_dir = '../uploads_group_files';
    if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0777, true);

    $tmp_name = $_FILES['file']['tmp_name'];
    $name = basename($_FILES['file']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido']);
        exit;
    }

    $new_name = uniqid() . '.' . $ext;
    $destination = "$uploads_dir/$new_name";

    if (move_uploaded_file($tmp_name, $destination)) {
        $file_path = $destination;
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload do arquivo']);
        exit;
    }
}

if (!$message && !$file_path) {
    echo json_encode(['success' => false, 'message' => 'Mensagem ou arquivo obrigatórios']);
    exit;
}

// Verifica se o usuário é membro do grupo antes de inserir (segurança)
$stmt_check = $conexao->prepare("SELECT 1 FROM grupo_membros WHERE id_grupo = ? AND id_usuario = ?");
$stmt_check->bind_param("ii", $id_grupo, $sender_id);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Você não é membro deste grupo']);
    exit;
}

$stmt = $conexao->prepare("INSERT INTO messages_group (id_grupo, sender_id, message, file_path, timestamp) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("iiss", $id_grupo, $sender_id, $message, $file_path);
$stmt->execute();

echo json_encode(['success' => true]);
?>
