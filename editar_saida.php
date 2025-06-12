<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar saída</title>
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
        font-weight: bold;
        font-size: 24px;
    }

    p {
        font-weight: bold;
        font-size: 16px;
        line-height: 1.6;
    }
</style>
</head>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Saída</h4>
    <form action="atualizar_saida.php" method="POST">
        <?php
            $sql = "SELECT * FROM saida WHERE id = $id";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $id = $array['id'];
                $quantos = $array['quantos'];
                $descricao = $array['descricao'];
                $fmpag = $array['fmpag'];
                $responsavel = $array['responsavel'];   
                $data = $array['data'];   
                $nomeBanco = $array['nomeBanco'];
        ?>
        <input style="display:none" id="id" name="id" value="<?=$id?>">
        <div class="form-group">
            <label for="quantos">Valor</label>
            <input type="number" class="form-control" id="quantos" placeholder="Digite o novo valor"
                name="quantos" required autocomplete="off" step="0.01"  value="<?=$quantos?>">
        </div>
        <div class="form-group">
            <label for="descricao">descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao"
                placeholder="Digite a descrição da saida" autocomplete="off" value="<?=$descricao?>">
        </div>
        <div class="form-group">
                <label for="fmpag">Forma de pagamento?</label>
                <input type="text" class="form-control" id="fmpag" name="fmpag"
                    placeholder="Ex: Dinheiro, Cartão ou pix" autocomplete="off" value="<?=$fmpag?>">
            </div>
            <div class="form-group">
                <label for="responsavel">Usuário responsavel pela venda:</label>
                <select class="form-control" id="responsavel" name="responsavel">
                <?php
                $sqluser = "SELECT * FROM usuario ORDER BY Nome ASC";
                $usuario = mysqli_query($conexao,$sqluser);
                while($array = mysqli_fetch_array($usuario, MYSQLI_ASSOC)){
                    $IdUsuario = $array["IdUsuario"];
                    $nome = $array["Nome"];
                ?>
                <option><?=$nome?></option>
                <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="data">Qual a data dessa saída?</label>
                <input type="date" class="form-control" id="data" name="data"
                placeholder="Data da saída" required autocomplete="off" value="<?=$data?>">
            </div>
            <div class="form-group">
                <label for="nomeBanco">Qual a conta utilizada para o pagamento?</label>
                <input type="text" class="form-control" id="nomeBanco" name="nomeBanco"
                placeholder="Ex: Caixa, C/C, etc.." required autocomplete="off" value="<?=$nomeBanco?>">
            </div>
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>