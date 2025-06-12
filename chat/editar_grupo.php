<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = intval($_POST['group_id']);
    $newName = mysqli_real_escape_string($conexao, $_POST['group_name']);
    $uploadDir = 'uploads_imggrupo/';
    $imagePath = null;

    // Verifica e faz upload da nova imagem (se houver)
    if (isset($_FILES['group_photo']) && $_FILES['group_photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['group_photo']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('grupo_') . '.' . $ext;
        $fullPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['group_photo']['tmp_name'], $fullPath)) {
            $imagePath = 'uploads_imggrupo/' . $fileName; // Caminho relativo usado no sistema
        } else {
            die('Erro ao mover o arquivo.');
        }
    }

    // Atualiza no banco de dados
    $updateSQL = "UPDATE grupos SET nome = '$newName'";
    if ($imagePath) {
        $updateSQL .= ", imagem_grupo = '$imagePath'";
    }
    $updateSQL .= " WHERE id = $groupId";

    if (mysqli_query($conexao, $updateSQL)) {
        header("Location: chat_grupo.php");
        exit;
    } else {
        echo "Erro ao atualizar grupo: " . mysqli_error($conexao);
    }
}
?>
