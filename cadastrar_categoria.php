<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de Categoria</title>
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
        line-height: 1.6;
        font-weight: bold;
    }
</style>
<body>
    <?php include_once('menu.php'); ?>
    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom"> Cadastro de Categoria</h4>
        <form action="inserir_categoria.php" method="POST">
            <div class="form-group">
                <label for="numeroProduto">Nome Categoria</label>
                <input type="text" class="form-control" id="nomeCategoria" placeholder="Digite o nome da categoria"
                    name="nomeCategoria" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="catalogo">Adicionar ao catálogo:</label>
                <select name="catalogo" id="catalogo" class="form-control">
                    <option value="s">Sim</option>
                    <option value="n">Não</option>
                </select>
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_categorias.php" class="btn-enviar btn btn-success btn-sm btn-block">Listagem de categorias</a>
        </form>
    </div>


    <?php include_once('footer.php'); ?>
</body>

</html>