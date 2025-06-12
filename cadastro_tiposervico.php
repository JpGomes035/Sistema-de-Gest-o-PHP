<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Tipos de serviço</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de tipos de serviços para usar no cadastro de OS</h4>
        <form action="inserir_tipo_servico.php" method="POST">
            <div class="form-group">
                <label for="nomeServico">Tipo do serviço:</label>
                <input type="text" class="form-control" id="nomeServico" placeholder="EX: Manutenção.." name="nomeServico" required autocomplete="off">
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
        </form>
        <button id="btnCadastro" class="btn-enviar btn btn-success btn-sm btn-block"><i class="fa fa-plus" aria-hidden="true"></i> Cadastrar OS</button>

        <button id="btnListar" class="btn-enviar btn btn-success btn-sm btn-block"> Listar OS</button>

        <script>
            document.getElementById("btnCadastro").addEventListener("click", function() {
                window.location.href = "cadastro_os.php";
            });
        </script>

        <script>
            document.getElementById("btnListar").addEventListener("click", function() {
                window.location.href = "listar_tipo_os.php";
            });
        </script>

    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>