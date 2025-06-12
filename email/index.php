<?php
include_once '../iniciar_sessao.php';
include_once '../head.php';

// Conectar ao banco de dados para obter o nome do usuário
$usuarioLogado = $_SESSION["usuario"];
$sql = "SELECT Nome, Email FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
$retorno = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($retorno);
$nomeUsuario = $array['Nome'];
$EmailUser = $array['Email'];

// Verificar se o parâmetro emailCliente está presente na URL
$emailDest = isset($_GET['emailCliente']) ? $_GET['emailCliente'] : '';

// Se emailCliente não estiver presente, verificar o parâmetro emailForn
if (empty($emailDest)) {
    $emailDest = isset($_GET['emailForn']) ? $_GET['emailForn'] : '';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email ProControl</title>
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #b3e0e0, #1e1e1e);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 28px;
        }

        h6 {
            margin-bottom: 20px;
            color: #777;
            font-size: 16px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus,
        textarea:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.2);
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons button,
        .buttons a {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
            display: inline-block;
            color: #fff;
            text-align: center;
        }

        .buttons button {
            background-color: #28a745;
        }

        .buttons button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .buttons button:active {
            background-color: #1e7e34;
            transform: translateY(0);
        }

        .buttons .list-emails {
            background-color: #007bff;
        }

        .buttons .list-emails:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .buttons .list-emails:active {
            background-color: #004085;
            transform: translateY(0);
        }

        #response {
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }

        a.voltar {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        a.voltar:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>ProControl Email</h2>
        <h6>Alguns e-mails levam 2-5 minutos para entregar.</h6>
        <form id="contactForm" enctype="multipart/form-data" method="POST" action="send_email.php">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($nomeUsuario); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($EmailUser); ?>">

            <label for="to">Email destinatário:</label>
            <input type="email" id="to" name="to" required value="<?php echo htmlspecialchars($emailDest); ?>">

            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" required></textarea>

            <label for="attachment">Anexo:</label>
            <input type="file" id="attachment" name="attachment">

            <div class="buttons">
                <button type="submit">Enviar</button>
                <a href="listar_email.php" class="list-emails">Listar Emails</a>
            </div>
            <a href="../home.php" class="voltar">Voltar</a>
        </form>
        <div id="response"></div>
    </div>
</body>

</html>
