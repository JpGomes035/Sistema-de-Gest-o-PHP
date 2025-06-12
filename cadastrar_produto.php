<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
include_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="en">

<title>Cadastro de Produto</title>
<style>
    body {
        background: linear-gradient(to bottom, #4daaaa, #a7a4a4);
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

    h1 {
        font-size: 24px;
        font-weight: bold;
    }

    p {
        font-size: 16px;
        font-weight: bold;
        line-height: 1.6;
    }
</style>

<body>
    <?php include_once 'menu.php'; ?>

    <div style="padding:20px 0;max-width:800px" class="container">
        <br>
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de Produto</h4>
        <form action="inserir_produto.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="numeroProduto">Número Produto</label>
                <input type="text" class="form-control" id="numeroProduto" placeholder="Digite o número do produto" name="numeroProduto" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nomeProduto">Nome Produto</label>
                <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" placeholder="Digite o nome do produto" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="precovenda">Preço Base de venda</label>
                <input type="number" step="0.01" class="form-control" id="precovenda" name="precovenda" placeholder="Digite o preço do produto(Usar . para diferenciar os valores ex(150.99))" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="quantidadeProduto">Quantidade</label>
                <input type="number" class="form-control" id="quantidadeProduto" name="quantidadeProduto" placeholder="Digite a quantidade do produto" autocomplete="off" required>
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
                    ?>
                        <option><?= $nomeCategoria ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fornecedor">Fornecedor</label>
                <select class="form-control" id="fornecedor" name="fornecedor" required>
                    <?php
                    // puxar todos os forn cadastrados
                    $sqlFornecedor = "SELECT * FROM fornecedor ORDER BY nomeForn ASC";
                    $retornoFornecedor = mysqli_query($conexao, $sqlFornecedor);
                    while ($array = mysqli_fetch_array($retornoFornecedor, MYSQLI_ASSOC)) {
                        $idFornecedor = $array["IdFornecedor"];
                        $nomeFornecedor = $array["nomeForn"];
                    ?>
                        <option><?= $nomeFornecedor ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="unidade_estoque">Qual a unidade de medida?</label>
                <input type="text" class="form-control" id="unidade_estoque" name="unidade_estoque" placeholder="Ex: Unid, Litro, Caixa..." autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="descProd">Informações complementares</label>
                <textarea class="form-control" id="descProd" name="descProd" placeholder="Informações complementares do produto" autocomplete="off" required></textarea>
            </div>
            <div class="form-group">
                <label for="precoPromocional">Preço Promocional do Produto: </label>
                <input type="text" class="form-control" id="precoPromocional" name="precoPromocional"
                    placeholder="Preço Promocional do produto(Usar . para diferenciar os valores ex(150.99))" step="0.01" autocomplete="off"required>
            </div>
            <div class="form-group">
                <label for="status_prod">Status atual do produto?</label>
                <input type="text" class="form-control" id="status_prod" name="status_prod" placeholder="Estragado, manutenção, em uso, etc.." autocomplete="off">
            </div>

            <div class="form-group">
                <label for="img_prod">Imagem do Produto</label>
                <input type="file" class="form-control" id="img_prod" name="img_prod" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="catalogo">Adicionar ao catálogo:</label>
                <select name="catalogo" id="catalogo" class="form-control">
                    <option value="s">Sim</option>
                    <option value="n">Não</option>
                </select>
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_produtos.php" class="btn-enviar btn btn-success btn-sm btn-block">Listar produtos</a>

        </form>
    </div>

    <?php include_once 'footer.php'; ?>
</body>

</html>