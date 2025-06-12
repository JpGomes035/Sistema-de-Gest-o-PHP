<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Tabela de Preço</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de tabela de preço</h4>
        <form action="inserir_tabela_preco.php" method="POST">
            <div class="form-group">
                <label for="nome_tbl">Nome da tabela</label>
                <input type="text" class="form-control" id="nome_tbl" placeholder="Digite o nome da tabela"
                name="nome_tbl" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="preco_tbl">Preço da Tabela</label>
                <input type="text" class="form-control" id="preco_tbl" placeholder="Digite o preço da tabela"
                    name="preco_tbl"  step="0.01" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="descricao_tbl">Descrição da Tabela</label>
                <input type="text" class="form-control" id="descricao_tbl" placeholder="Qual a descrição dessa tabela?"
                    name="descricao_tbl" autocomplete="off">
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_tabela_preco.php" class="btn-enviar btn btn-success btn-sm btn-block">Listagem de preços</a>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>