<?php
include_once 'conexao.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $resp = $_POST['resp'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $telAgenda = $_POST['telAgenda'];

    // Inserir no banco de dados
    $sql = "INSERT INTO `agenda` (`titulo`, `resp`, `data`, `descricao`, `nivelAprov`, `telAgenda`) VALUES ('$titulo', '$resp', '$data', '$descricao', 'Ativo', '$telAgenda')";
    $inserir = mysqli_query($conexao, $sql);

    if ($inserir) {
        // Obter o email do responsável
        $sqlEmail = "SELECT Email FROM usuario WHERE Nome = '$resp' AND Status = 'Ativo'";
        $resultado = mysqli_query($conexao, $sqlEmail);
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario) {
            $emailResponsavel = $usuario['Email'];

            // Enviar email para o responsável
            $assunto = "Novo Agendamento: $titulo";
            $mensagem = "Olá $resp,\n\nUm novo agendamento foi criado.\n\nTítulo: $titulo\nData: $data\nDescrição: $descricao\nTelefone: $telAgenda\n\n Atenciosamente,\nSua Empresa";

            $headers = "From: novoagendamento@procontrol.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($emailResponsavel, $assunto, $mensagem, $headers)) {
                echo 'Agendamento criado e email enviado com sucesso!';
            } else {
                echo 'Agendamento criado, mas falha ao enviar o email.';
            }
        } else {
            echo 'Agendamento criado, mas não foi possível encontrar o email do responsável.';
        }

        // Redirecionar para agenda.php
        header("Location: agenda.php");
        exit();
    } else {
        echo 'Erro ao criar agendamento. Por favor, tente novamente.';
    }
}
?>
