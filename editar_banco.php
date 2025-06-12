<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id = $_GET['id'];

?>
<head>
    <title>Editar banco</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
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
        font-weight: bold;
        line-height: 1.6;
    }
</style>
</head>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Banco</h4>
    <form action="atualizar_banco.php" method="POST">
        <?php
            $sql = "SELECT * FROM banco WHERE idBanco = $id";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $idBanco = $array['idBanco'];
                $nomeBanco = $array['nomeBanco'];
                $agencia = $array['agencia'];
                $cc = $array['cc'];
                $valor_banco = $array['valor_banco'];
        ?>
        <input style="display:none" id="idBanco" name="idBanco" value="<?=$idBanco?>">
        <div class="form-group">
            <label for="nomeBanco">Nome do Banco</label>
            <input type="text" class="form-control" id="nomeBanco" placeholder="Digite o nome do Banco:"
            name="nomeBanco" required autocomplete="off" value="<?=$nomeBanco?>">
        </div>
        <div class="form-group">
            <label for="agencia">Número da Agência:</label>
            <input type="text" class="form-control" id="agencia" placeholder="Número da agência" name="agencia" autocomplete="off" value="<?=$agencia?>">
            <script>
    $(document).ready(function() {
      // Aplica a máscara no campo de número da agência
      $('#agencia').inputmask('9999');
    });
  </script>     
            </div>
            <div class="form-group">
                <label for="cc">Conta Corrente (C/C)</label>
                <input type="text" class="form-control" id="cc" placeholder="Digite a conta corrente" name="cc" required autocomplete="off" value="<?=$cc?>">
                <script>
                $(document).ready(function() {
                 // Aplica a máscara no campo de conta corrente
                 $('#cc').inputmask('99999-9');
                });
            </script>
            </div>
            <div class="form-group">
            <label for="valor_banco">Valor no Banco</label>
            <input type="number" class="form-control" id="valor_banco" placeholder="Digite o valor no Banco:"
            name="valor_banco" required autocomplete="off" step="0.01" value="<?=$valor_banco?>">
        </div>
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>