<?php
include_once '../iniciar_sessao.php';
include_once '../head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Backups</title>
    <style>
     body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
            color: black;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-weight: bold;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .backup-list {
            list-style-type: none;
            padding: 0;
        }

        .backup-list li {
            margin-bottom: 10px;
        }

        .backup-name {
            color: blue;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <h1>Listagem de Backup</h1>
        <p>Essa pagina foi criada para confirmar os backups já feitos e que estão salvos na pasta de backups dentro do servidor.</p>
        <h5>Legenda: BACKUP_DIA_MÊS_ANO_HORA_MINUTO_SEGUNDO</h5>
        <h5>Dados na pasta de backup:</h5>
        <ul class="backup-list">
            <?php
            // Caminho para a pasta de backups
            $backupPath = 'backups/';

            // Obtém todos os arquivos na pasta de backup
            $backupFiles = scandir($backupPath);

            // Exclui os diretórios . e ..
            $backupFiles = array_diff($backupFiles, array('.', '..'));

            // Itera sobre os arquivos de backup
            foreach ($backupFiles as $backupFile) {
                // Exibe apenas o nome do arquivo
                echo "<li><span class='backup-name' download >$backupFile</span></li>";
            }
            ?>
        </ul>
        <a href="../painel.php">Voltar para o Painel</a>
    </div>
</body>

</html>
