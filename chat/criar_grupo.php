<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../iniciar_sessao.php';
include_once '../conexao.php';

$data = json_decode(file_get_contents('php://input'), true);
$nomeGrupo = mysqli_real_escape_string($conexao, $data['nomeGrupo'] ?? '');
$membros = $data['membros'] ?? [];

if (!$nomeGrupo || count($membros) < 2) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

// Cria o grupo
$sql = "INSERT INTO grupos (nome, criado_por) VALUES ('$nomeGrupo', {$_SESSION['usuario']})";
if (!mysqli_query($conexao, $sql)) {
    echo json_encode(['success' => false, 'message' => 'Erro ao criar grupo']);
    exit;
}

$idGrupo = mysqli_insert_id($conexao);

// Insere os membros
$valores = array_map(function ($id) use ($idGrupo) {
    return "($idGrupo, " . intval($id) . ")";
}, $membros);

// Adiciona quem criou, somente se ainda não estiver
if (!in_array($_SESSION['usuario'], $membros)) {
    $valores[] = "($idGrupo, {$_SESSION['usuario']})";
}

$sqlMembros = "INSERT INTO grupo_membros (id_grupo, id_usuario) VALUES " . implode(',', $valores);

if (!mysqli_query($conexao, $sqlMembros)) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao adicionar membros',
        'sql' => $sqlMembros,
        'erro' => mysqli_error($conexao)
    ]);
    exit;
}


echo json_encode(['success' => true]);
?>