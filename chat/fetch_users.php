<?php
include_once '../iniciar_sessao.php';
include_once '../conexao.php';

$sql = "
    SELECT 
        u.IdUsuario as id,
        u.Nome as name,
        u.Online,
        u.Setor,
        i.nome as imagem
    FROM usuario u
    LEFT JOIN (
        SELECT id_usuario, nome
        FROM imagens
        WHERE id_imagem IN (
            SELECT MAX(id_imagem)
            FROM imagens
            GROUP BY id_usuario
        )
    ) i ON u.IdUsuario = i.id_usuario
    WHERE u.Status = 'Ativo'
";

$retorno = mysqli_query($conexao, $sql);
$users = [];
while ($row = mysqli_fetch_assoc($retorno)) {
    $row['imagem'] = $row['imagem'] ? '../upload-imagens/' . $row['imagem'] : '../upload-imagens/default.jpg';
    $users[] = $row;
}

echo json_encode($users);
?>
