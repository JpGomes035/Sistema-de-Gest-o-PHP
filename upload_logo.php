<?php
include_once 'conexao.php';

if (isset($_FILES['nova_logo']) && $_FILES['nova_logo']['error'] == 0) {
  $extensao = strtolower(pathinfo($_FILES['nova_logo']['name'], PATHINFO_EXTENSION));
  $novo_nome = 'logo_' . time() . '.' . $extensao;
  $diretorio = 'upload-logo/';
  $caminho_completo = $diretorio . $novo_nome;

  if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
  }

  if (move_uploaded_file($_FILES['nova_logo']['tmp_name'], $caminho_completo)) {
    // Atualiza a imagem na tabela (supondo apenas 1 registro de info)
    $sql = "UPDATE informacoes SET imagemempresa = '$caminho_completo' LIMIT 1";
    if (mysqli_query($conexao, $sql)) {
      echo "<script>alert('Logo atualizada com sucesso!'); window.location='info_perfil.php';</script>";
    } else {
      echo "Erro ao atualizar o banco de dados.";
    }
  } else {
    echo "Erro ao mover o arquivo.";
  }
} else {
  echo "Erro ao enviar arquivo.";
}
?>
