<?php
include_once '../conexao.php';
include_once '../iniciar_sessao.php';
include_once '../head.php';

// Conectar ao banco de dados para obter o nome do usuário
$usuarioLogado = $_SESSION["usuario"];
$sql = "SELECT Nome, Email FROM usuario WHERE IdUsuario = ? AND Status = 'Ativo'";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $usuarioLogado);
$stmt->execute();
$result = $stmt->get_result();
$array = $result->fetch_array(MYSQLI_ASSOC);
$nomeUsuario = $array['Nome'];
$EmailUser = $array['Email'];
$stmt->close();

$sql = "SELECT id_info, nome, cnpj, email, telefone, rua, cep, cidade FROM `informacoes`";
$retorno = mysqli_query($conexao, $sql);

$uploadDir = 'anexo_email/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
    $id_info = $array['id_info'];
    $nomeEmpresa = $array['nome'];
    $cnpj = $array['cnpj'];
    $email = $array['email'];
    $telefone = $array['telefone'];
    $rua = $array['rua'];
    $cep = $array['cep'];
    $cidade = $array['cidade'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $to = filter_var($_POST['to'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    $attachment = $_FILES['attachment'];

    if ($name && $email && $message && $to) {
        $boundary = md5(time());

        // Headers
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        // Message Body
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= "Nome: $name\nEmail: $email\n\nMensagem:\n$message\r\n";

        // Attachment
        if ($attachment['error'] == UPLOAD_ERR_OK) {
            $filePath = $attachment['tmp_name'];
            $originalFileName = basename($attachment['name']);
            $fileType = $attachment['type'];

            // Gerar um prefixo aleatório
            $randomPrefix = bin2hex(random_bytes(8)); // Gera um prefixo de 16 caracteres hexadecimais

            // Criar um nome de arquivo único
            $fileName = $randomPrefix . '_' . $originalFileName;

            // Definir o caminho completo para o anexo
            $uploadFilePath = $uploadDir . $fileName;

            // Mover o arquivo para a pasta "anexo_email"
            if (move_uploaded_file($filePath, $uploadFilePath)) {
                $body .= "--$boundary\r\n";
                $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
                $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $body .= chunk_split(base64_encode(file_get_contents($uploadFilePath))) . "\r\n";
            }
        }

        $body .= "--$boundary--";

        // Enviar e-mail
        if (mail($to, 'Nova mensagem de contato da: ' . $nomeEmpresa, $body, $headers)) {
            echo 'E-mail enviado com sucesso!';

            // Definir o fuso horário para São Paulo
            date_default_timezone_set('America/Sao_Paulo');

            // Obter a data e hora atual no fuso horário definido
            $dataEnvio = date('Y-m-d H:i:s');

            // Inserir dados no banco de dados
            $anexoNome = $attachment['error'] == UPLOAD_ERR_OK ? $fileName : null;
            $anexoTipo = $attachment['error'] == UPLOAD_ERR_OK ? $fileType : null;
            $anexoCaminho = $attachment['error'] == UPLOAD_ERR_OK ? $uploadFilePath : null;

            $sqlInsert = "INSERT INTO emails_enviados (nome, email, destinatario, mensagem, anexo_nome, anexo_tipo, anexo_caminho, data_envio, visualizar)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexao->prepare($sqlInsert);

            // Definir a variável para o campo 'visualizar'
            $visualizar = 's';

            $stmt->bind_param("sssssssss", $name, $email, $to, $message, $anexoNome, $anexoTipo, $anexoCaminho, $dataEnvio, $visualizar);
            $stmt->execute();
            $stmt->close();

            // Espera por 1 segundo
            sleep(1);

            // Redireciona para listar_email.php
            header("Location: listar_email.php");
        } else {
            echo 'Falha ao enviar o e-mail. Por favor, tente novamente.';
        }
    } else {
        echo 'Por favor, preencha todos os campos corretamente.';
    }
} else {
    echo 'Método de requisição inválido.';
}
