<?php
include_once '../iniciar_sessao.php';
include_once '../head.php';

// Conectar ao banco de dados
$usuarioLogado = $_SESSION["usuario"];
$sql = "SELECT Nome, Email FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
$retorno = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($retorno);
$nomeUsuario = $array['Nome'];
$EmailUser = $array['Email'];

// Definir o limite de tempo (72 horas atrás)
$limiteTempo = date('Y-m-d H:i:s', strtotime('-72 hours'));

// Atualizar o campo 'visualizar' para 'n' para emails enviados há mais de 72 horas
$sql = "UPDATE emails_enviados SET visualizar = 'n' WHERE data_envio < '$limiteTempo'";
mysqli_query($conexao, $sql);

// Consulta todos os emails enviados que ainda devem ser visualizados
$sql = "SELECT id, nome, email, destinatario, mensagem, anexo_nome, anexo_tipo, anexo_caminho, data_envio 
        FROM emails_enviados 
        WHERE visualizar = 's' 
        ORDER BY data_envio DESC";
$retorno = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Emails Enviados</title>
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <link rel="stylesheet" href="stylelistar.css">
</head>

<body>
    <div class="container">
        <h2>Listagem de Emails Enviados</h2>
        <h4>Os emails somem após 3 dias.</h4>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Destinatário</th>
                    <th>Mensagem</th>
                    <th>Anexo</th>
                    <th>Data de Envio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($retorno)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['destinatario']); ?></td>
                        <td class="message"><?php echo nl2br(htmlspecialchars($row['mensagem'])); ?></td>
                        <td>
                            <?php if ($row['anexo_nome']): ?>
                                <a href="anexo_email/<?php echo htmlspecialchars($row['anexo_nome']); ?>" target="_blank"><?php echo htmlspecialchars($row['anexo_nome']); ?></a>
                            <?php else: ?>
                                Sem anexo
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['data_envio']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="index.php" class="back-button"><button>Voltar</button></a>
    </div>
</body>

</html>