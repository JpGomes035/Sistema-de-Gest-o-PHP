<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesquisa de CEP</title>

       <style>
    body {
        background: linear-gradient(to bottom, #2a9d8f, #264653);
        color: black;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        font-weight: bold;
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
    }

    p {
        font-size: 16px;
        font-weight: bold;
        line-height: 1.6;
    }


h2 {
    color: #333;
    font-weight: bold;
    font-size: 23px;
}

form {
    margin-bottom: 20px;

}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"] {
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button[type="submit"] {
    padding: 5px 10px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0069d9;
}

strong {
    color: #333;
}

p {
    margin-bottom: 10px;
    color: #333;
}


   
    h1 {
        font-size: 24px;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
    }

    </style>
</head>
<body>
<?php include_once 'menu.php';?>
    <h2><b>Pesquisa de CEP</b></h2>
    <form method="POST" action="">
        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" maxlength="9" required>
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cep = $_POST['cep'];
        $cep = preg_replace('/[^0-9]/', '', $cep); // Remove caracteres não numéricos

        if (strlen($cep) === 8) {
            $url = "https://viacep.com.br/ws/{$cep}/json/";
            $resultado = file_get_contents($url);

            if ($resultado) {
                $dados = json_decode($resultado, true);

                if (isset($dados['erro'])) {
                    echo "CEP não encontrado.";
                } else {
                    echo "<strong>Endereço encontrado:</strong><br>";
                    echo "CEP: {$dados['cep']}<br>";
                    echo "Logradouro: {$dados['logradouro']}<br>";
                    echo "Bairro: {$dados['bairro']}<br>";
                    echo "Cidade: {$dados['localidade']}<br>";
                    echo "Estado: {$dados['uf']}<br>";
                }
            } else {
                echo "Erro ao buscar o CEP. Por favor, tente novamente mais tarde. <br> Busca alternativa: https://buscacepinter.correios.com.br/app/endereco/index.php?t";
            }
        } else {
            echo "CEP inválido. Certifique-se de digitar apenas os números.";
        }
    }
    ?>
    <br>
     <a href="listar_fornecedor.php" class="voltar">Voltar</a>
</body>
</html>
