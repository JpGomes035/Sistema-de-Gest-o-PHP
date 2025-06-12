<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Cadastro de Banco</title>
  <title>Máscara de Agência Bancária</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
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
</head>
    <?php include_once('menu.php'); ?>
<body>


  <script>
    $(document).ready(function() {
      // Aplica a máscara no campo de número da agência
      $('#agencia').inputmask('9999');
    });
  </script>
</body>
</html>


    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de Banco</h4>
        <form action="inserir_banco.php" method="POST">
            <div class="form-group">
                <label for="Nome">Nome do Banco</label>
                <input type="text" class="form-control" id="nomeBanco" placeholder="Digite o nome do Banco:"
                name="nomeBanco" required autocomplete="off">
            </div>  
            <div class="form-group">
            <label for="agencia">Número da Agência:</label>
            <input type="text" class="form-control" id="agencia" placeholder="Número da agência" name="agencia" autocomplete="off">
            <script>
    $(document).ready(function() {
      // Aplica a máscara no campo de número da agência
      $('#agencia').inputmask('9999');
    });
  </script>     
            </div>
            <div class="form-group">
                <label for="cc">Conta Corrente (C/C)</label>
                <input type="text" class="form-control" id="cc" placeholder="Digite a conta corrente" name="cc"autocomplete="off">
                <script>
                $(document).ready(function() {
                 // Aplica a máscara no campo de conta corrente
                 $('#cc').inputmask('99999-9');
                });
            </script>
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_banco.php" class="btn-enviar btn btn-success btn-sm btn-block">Listagem de bancos</a>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>