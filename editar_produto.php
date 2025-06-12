<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id = $_GET['id'];

$sql = "SELECT * FROM estoque WHERE IdProduto = $id";
$retorno = mysqli_query($conexao, $sql);

if (mysqli_num_rows($retorno) == 0) {
    echo "Produto não encontrado.";
    exit();
}

$produto = mysqli_fetch_array($retorno, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <style>
        body {
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select {
            width: 100%;
            padding: 10px;
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
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Editar Produto</h2>
        <form action="atualizar_produto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idProduto" value="<?= $produto['IdProduto'] ?>">

            <div class="form-group">
                <label for="Numero">Número do Produto:</label>
                <input type="text" id="Numero" name="Numero" value="<?= $produto['Numero'] ?>" required>
            </div>

            <div class="form-group">
                <label for="nomeProduto">Nome do Produto:</label>
                <input type="text" id="nomeProduto" name="nomeProduto" value="<?= $produto['Nome'] ?>" required>
            </div>

            <div class="form-group">
                <label for="quantidadeProduto">Quantidade:</label>
                <input type="number" id="quantidadeProduto" name="quantidadeProduto" value="<?= $produto['Quantidade'] ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <?php
                    // puxar todas as categorias cadastradas
                    $sqlCategoria = "SELECT * FROM categoria ORDER BY Nome ASC";
                    $retornoCategoria = mysqli_query($conexao, $sqlCategoria);
                    while ($array = mysqli_fetch_array($retornoCategoria, MYSQLI_ASSOC)) {
                        $idCategoria = $array["IdCategoria"];
                        $nomeCategoria = $array["Nome"];
                        // Verifica se a categoria atual é a do produto
                        $selected = ($produto['Categoria'] == $nomeCategoria) ? 'selected' : '';
                    ?>
                        <option value="<?= $nomeCategoria ?>" <?= $selected ?>><?= $nomeCategoria ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fornecedor">Fornecedor</label>
                <select class="form-control" id="Fornecedor" name="Fornecedor" required>
                    <?php
                    // puxar todos os fornecedores cadastrados
                    $sqlFornecedor = "SELECT * FROM fornecedor ORDER BY nomeForn ASC";
                    $retornoFornecedor = mysqli_query($conexao, $sqlFornecedor);
                    while ($array = mysqli_fetch_array($retornoFornecedor, MYSQLI_ASSOC)) {
                        $idFornecedor = $array["IdFornecedor"];
                        $nomeFornecedor = $array["nomeForn"];
                        // Verifica se o fornecedor atual é o do produto
                        $selected = ($produto['Fornecedor'] == $nomeFornecedor) ? 'selected' : '';
                    ?>
                        <option value="<?= $nomeFornecedor ?>" <?= $selected ?>><?= $nomeFornecedor ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="precovenda">Preço de Venda:</label>
                <input type="number" id="precovenda" name="precovenda" value="<?= $produto['precovenda'] ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="img_prod">Imagem do Produto:</label>
                <input type="file" id="img_prod" name="img_prod">
            </div>
            
            <div class="form-group">
                <label for="catalogo">Adicionar ao catálogo:</label>
                <select name="catalogo" id="catalogo" class="form-control">
                    <option value="s" <?= ($produto['catalogo'] == 's') ? 'selected' : '' ?>>Sim</option>
                    <option value="n" <?= ($produto['catalogo'] == 'n') ? 'selected' : '' ?>>Não</option>
                </select>
            </div>

            <div class="form-group">
                <label for="promocao">Preço Promocional:</label>
                <select name="promocao" id="promocao" class="form-control">
                    <option value="s" <?= ($produto['promocao'] == 's') ? 'selected' : '' ?>>Sim</option>
                    <option value="n" <?= ($produto['promocao'] == 'n') ? 'selected' : '' ?>>Não</option>
                </select>
            </div>

            <button type="submit">Atualizar Produto</button>
        </form>
    </div>
</body>

</html>
