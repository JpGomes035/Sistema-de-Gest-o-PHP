<?php
header('Content-Type: application/json');
include '../conexao.php';
session_start();

$usuarioLogado = $_SESSION['usuario'] ?? null;

if (!$usuarioLogado) {
    echo json_encode([]);
    exit;
}

// Busca somente os grupos em que o usuário logado participa
$query = "
    SELECT 
        g.id, 
        g.nome AS nomeGrupo, 
        g.imagem_grupo, 
        GROUP_CONCAT(u.Nome ORDER BY u.Nome ASC) AS membros
    FROM grupos g
    JOIN grupo_membros gm ON gm.id_grupo = g.id
    JOIN usuario u ON gm.id_usuario = u.IdUsuario
    WHERE g.id IN (
        SELECT id_grupo FROM grupo_membros WHERE id_usuario = $usuarioLogado
    )
    AND g.deletado = 'n'
    GROUP BY g.id
";

$result = mysqli_query($conexao, $query);

$groups = [];

while ($row = mysqli_fetch_assoc($result)) {
    $groups[] = [
        'id' => $row['id'],
        'nome' => $row['nomeGrupo'],
        'membros' => $row['membros'],
        'imagem_grupo' => $row['imagem_grupo'] ? '' . $row['imagem_grupo'] : null
    ];
}

echo json_encode($groups);
