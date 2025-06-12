<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$idAgenda = $_GET['idAgenda'];
?>
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
        font-weight: bold;
        justify-content: center;
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
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Formulário de Cadastro de Produto</h4>
    <form action="atualizar_cliente.php" method="POST">
        <?php
            $sql = "SELECT * FROM agenda WHERE idAgenda = $idAgenda";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $idAgenda = $array['idAgenda'];
                $titulo = $array['titulo'];
                $data = $array['data'];
                $descricao = $array['descricao'];
        ?>
        <input style="display:none" id="idAgenda" name="idAgenda" value="<?=$idAgenda?>">
        <div class="form-group">
            <label for="titulo">titulo do Cliente</label>
            <input type="text" class="form-control" id="titulo" placeholder="Digite o titulo da categoria"
                name="titulo" required autocomplete="off" value="<?=$titulo?>">
        </div>
        <div class="form-group">
                <label for="data">Qual o número do cliente?</label>
                <input type="text" class="form-control" id="data" name="data"
                    placeholder="Ex: 35 98888-8888" autocomplete="off"required value="<?=$data?>">
            </div>
            <div class="form-group">
                <label for="descricao">Qual o descricao novo do cliente?</label>
                <input type="text" class="form-control" id="descricao" name="descricao"
                    placeholder="Ex: exemplo@gmail.com" autocomplete="off"required value="<?=$descricao?>">
            </div>
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>