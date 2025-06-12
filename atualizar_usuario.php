<?php
// Iniciar sessão e incluir conexão
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

// Capturar dados do formulário
$IdUsuario = $_POST['IdUsuario'];
$Nome = $_POST['nome'];
$Sobrenome = $_POST['sobrenome'];
$Email = $_POST['email'];
$NivelUsuario = $_POST['nivelUsuario'];
$telefoneUsuario = $_POST['telefoneUsuario'];
$cpfUsuario = $_POST['cpfUsuario'];
$Status = $_POST['Status'];
$Setor = $_POST['Setor'];
$Senha = isset($_POST['senha']) ? $_POST['senha'] : '';

// Escapar os valores para evitar SQL Injection
$Nome = mysqli_real_escape_string($conexao, $Nome);
$Sobrenome = mysqli_real_escape_string($conexao, $Sobrenome);
$Email = mysqli_real_escape_string($conexao, $Email);
$NivelUsuario = mysqli_real_escape_string($conexao, $NivelUsuario);
$telefoneUsuario = mysqli_real_escape_string($conexao, $telefoneUsuario);
$cpfUsuario = mysqli_real_escape_string($conexao, $cpfUsuario);
$Status = mysqli_real_escape_string($conexao, $Status);
$Setor = mysqli_real_escape_string($conexao, $Setor);
$Senha = mysqli_real_escape_string($conexao, $Senha);

// Construir a consulta SQL
$sql = "UPDATE usuario SET Nome = '$Nome', Sobrenome = '$Sobrenome', Email = '$Email', NivelUsuario = $NivelUsuario, telefoneUsuario = '$telefoneUsuario', cpfUsuario = '$cpfUsuario', Setor = '$Setor', Status = '$Status'";

// Adicionar atualização de senha se uma nova senha foi fornecida
if (!empty($Senha)) {
    $SenhaHash = sha1($Senha);
    $sql .= ", Senha = '$SenhaHash'";
}

$sql .= " WHERE IdUsuario = $IdUsuario";

// Executar a consulta
$update = mysqli_query($conexao, $sql);

// Verificar se a atualização foi bem-sucedida
if ($update) {
    header("Location: listar_usuario.php?atualizado=" . $IdUsuario);
} else {
    echo "Erro ao atualizar o usuário: " . mysqli_error($conexao);
}
