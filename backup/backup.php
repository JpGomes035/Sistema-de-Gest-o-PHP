<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup</title>
    <style>
        body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
<?php
// Atualizar para as configurações do DB do cliente quando estiver hospedado
$servername = 'localhost';
$database = 'u642887426_estoque';
$username = 'u642887426_joaopedro';
$password = '020404Joao*';

$conexao = mysqli_connect($servername, $username, $password, $database);
    // Caminho para salvar os backups
    // Colocar o caminho do storage que hospedagem fornece 
    $backupPath = 'backups/';
    // Define o fuso horário para o horário de Brasília
    date_default_timezone_set('America/Sao_Paulo');
    $backupFile = $backupPath . '_' . date('d-m-Y_H-i-s') . '_' . $database . '.sql';

    // Nome do arquivo de backup
    $backupFile = $backupPath . '_' . date('d-m-Y_H-i-s ') . $database . '.sql';

    try {
        // Conexão com o banco de dados usando PDO
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

        // Configuração para obter resultados como array associativo
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Configuração para lançar exceções em caso de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obter o conteúdo do banco de dados
        $query = $conn->prepare("SHOW CREATE DATABASE $database");
        $query->execute();
        $result = $query->fetch();

        // Salva a estrutura do banco de dados no arquivo de backup
        file_put_contents($backupFile, $result['Create Database'] . ";\n\n", FILE_APPEND);

        // Consulta para obter o conteúdo de cada tabela e salvar no arquivo de backup
        $tables = $conn->query("SHOW TABLES");
        foreach ($tables as $table) {
            $tableName = $table['Tables_in_' . $database];
            $query = $conn->prepare("SHOW CREATE TABLE $tableName");
            $query->execute();
            $tableCreate = $query->fetchColumn(1);

            // Salva o CREATE TABLE no arquivo de backup
            file_put_contents($backupFile, $tableCreate . ";\n\n", FILE_APPEND);

            // Consulta para obter o conteúdo dos dados e salvar no arquivo de backup
            $query = $conn->prepare("SELECT * FROM $tableName");
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                $sql = "INSERT INTO $tableName (" . implode(", ", array_keys($data[0])) . ") VALUES ";
                foreach ($data as $row) {
                    $sql .= "(" . implode(", ", array_map([$conn, 'quote'], $row)) . "), ";
                }
                $sql = rtrim($sql, ", ") . ";\n\n";
                file_put_contents($backupFile, $sql, FILE_APPEND);
            }
        }

        echo "Conferindo dados, tabelas... <br> Conferindo formato, Aguarde um instante... <br> Backup concluído em: " . date('Y-m-d H:i:s') . "\n <br> Enviando para a Pasta e Redirecionando...";
    } catch (PDOException $e) {
        echo "Erro ao fazer backup: " . $e->getMessage() . "\n";
    }
    ?>
    <br>
    <br>
    <script>
    setTimeout(function() {
        window.location.href = '../painel.php';
    }, 3000); // Tempo em milissegundos (3 segundos)
</script>

</body>
</html>