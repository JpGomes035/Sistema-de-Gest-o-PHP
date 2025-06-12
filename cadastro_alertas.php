<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de alerta</title>
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
    <?php include_once('conexao_alert.php'); ?> 
    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de Alerta</h4>
        <form action="inserir_alerta.php" method="POST">
        <div class="form-group">
                <input type="hidden" class="form-control" id="id" name="id">
            </div>
           <div class="form-group">
                <label>Titulo do Alerta</label>
                <input class="form-control" type="text" id= "descricao_Alerta" name="descricao_Alerta" placeholder="Digite o título do alerta"
                autocomplete="off" />
            </div>
            <div class="form-group">
                <label for="setor">setor</label>
                <select class="form-control" id="setor" name="setor" required>
                <?php
                $sqlSetor = "SELECT * FROM setor ORDER BY nomeSetor ASC";
                $retornoSetor = mysqli_query($conexao,$sqlSetor);
                while($array = mysqli_fetch_array($retornoSetor, MYSQLI_ASSOC)){
                    $idSetor = $array["id_Setor"];
                    $nomeSetor = $array["nomeSetor"];
                ?>
                <option><?=$nomeSetor?></option>
                <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="descricao_extendida">Qual a descrição do alerta?</label>
                <textarea name="descricao_extendida" id="descricao_extendida" class="form-control" required placeholder="Insira aqui o alerta com a descrição extendida" autocomplete="off"></textarea>
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>