<?php
// Conexão com o banco de dados
include_once '../conexao.php';

// Função para marcar o grupo como deletado
function excluirGrupo($idGrupo) {
    global $conexao;

    // Preparar a consulta para atualizar o status do grupo
    $stmt = $conexao->prepare("UPDATE grupos SET deletado = 's' WHERE id_grupo = ?");
    $stmt->bind_param("i", $idGrupo); // "i" indica que $idGrupo é um inteiro

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Grupo excluído com sucesso!";
    } else {
        echo "Erro ao excluir o grupo: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
}


// Fechar a conexão
$conexao->close();
?>
