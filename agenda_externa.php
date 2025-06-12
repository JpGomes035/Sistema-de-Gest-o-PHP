<?php
include_once('head.php');
//cadastrar agenda pra ser aprovada no inicio
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
    <title>Agenda</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            font-weight: bold;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }



        h2 {
            margin-bottom: 10px;
        }

        p {
            margin: 0;
            margin-bottom: 5px;
        }

        .container {
            padding: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .table th {
            font-weight: bold;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination-item {
            display: inline-block;
            margin-right: 5px;
        }

        .pagination-link {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination-link:hover {
            background-color: #45a049;
        }

        .pagination-link.active {
            background-color: #45a049;
            font-weight: bold;
        }

        .btn-success {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .descricao-expandir {
            cursor: pointer;
            text-align: center;
        }

        .descricao-expandir.descricao-expandida {
            white-space: normal;
            text-align: center;
        }

        .descricao-expandir .descricao-resumida {
            display: inline-block;
            overflow: hidden;
            text-align: center;
            text-overflow: ellipsis;
            max-width: 150px;
            /* Defina o tamanho máximo para exibição na célula */
        }

        .btn-expande-descricao {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1;
            border: none;
            background-color: transparent;
            color: #333;
            cursor: pointer;
            display: inline-block;
        }

        .btn-expande-descricao:focus {
            outline: none;
        }

        .btn-expande-descricao:hover {
            color: #666;
        }

        .btn-expande-descricao::before {
            content: '+';
        }

        .btn-expande-descricao.hidden {
            display: none;
        }

        .voltar {
            color: black;
            transition: color 0.3s ease-in-out;
        }

        .voltar:hover {
            color: red;
        }

        a {
            color: red;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: white;
        }

        body {
            background: linear-gradient(to bottom, #2a9d8f, #264653);

            color: black;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        th,
        tr,
        td {
            text-align: center;
        }
    </style>
</head>

<body>

    <div style="padding:20px 0" class="container">
        <h1>Agendamento externo</h1>

        <form method="post" action="inserir_agendamento_externo.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>

            <div class="form-group">
                <label for="numero">Qual o número para contato?</label>
                <input type="text" class="form-control" id="telAgenda" name="telAgenda"
                    placeholder="Ex: 35 8888-8888, sem o numero '9'" autocomplete="off" maxlength="11">
                <script>
                    // Função para formatar o telefone
                    function formatarTelefone(telefone) {
                        // Remove todos os caracteres que não são números
                        telefone = telefone.replace(/\D/g, '');

                        // Verifica se o telefone possui 10 ou 11 dígitos
                        if (telefone.length === 10 || telefone.length === 11) {
                            // Aplica a máscara com o formato +55 (XX) XXXXX-XXXX
                            telefone = telefone.replace(/(\d{2})(\d{4,5})(\d{4})/, '+55 ($1) $2-$3');
                        }

                        return telefone;
                    }

                    // Função para aplicar a máscara quando o campo de telefone for preenchido
                    function aplicarMascaraTelefone() {
                        var telefoneInput = document.getElementById('telAgenda');
                        telefoneInput.value = formatarTelefone(telefoneInput.value);
                    }

                    // Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
                    document.getElementById('telAgenda').addEventListener('input', aplicarMascaraTelefone);
                </script>

                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao"
                    placeholder="Coloque pra gente o motivo do seu agendamento com seu nome e o horário por favor."
                    required></textarea>

                <div class="form-group">
                    <input type="hidden" class="form-control" id="nivelAprov" name="nivelAprov">
                </div>

                <button type="submit">Enviar agendamento</button>
                <a href="login.php" class="voltar">Voltar</a>

        </form>
        <?php include_once('footer.php'); ?>