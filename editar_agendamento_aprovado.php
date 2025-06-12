<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$idAgenda = $_GET['idAgenda'];
?>
<title>Aprovar</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
<style>
    body {
        background: linear-gradient(to bottom, #2a9d8f, #264653);
        color: black;
        font-family: 'Poppins', sans-serif;
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
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Aprovação de Agendamento
    </h4>
    <form action="inserir_agendamento_aprovado.php" method="POST">
        <?php
            $sql = "SELECT * FROM agenda WHERE idAgenda = $idAgenda";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $idAgenda = $array['idAgenda'];
                $titulo = $array['titulo'];
                $data = $array['data'];
                $descricao = $array['descricao'];
                $telAgenda = $array['telAgenda'];
                
        ?>
        <input style="display:none" id="idAgenda" name="idAgenda" value="<?=$idAgenda?>">

        <div class="row">
            <div class="form-group col-md-6">
                <label for="titulo">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required autocomplete="off"
                    value="<?=$titulo?>" readonly>
            </div>


            <div class="form-group col-md-6">
                <label for="Data">Data</label>
                <input type="date" class="form-control" id="data" name="data" required autocomplete="off"
                    value="<?=$data?>" readonly>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required autocomplete="off"
                    value="<?=$descricao?>" readonly>
            </div>

            <div class="form-group col-md-6">
                <label>Aprovar?</label>
                <select class="form-control" name="nivelAprov" autocomplete="off" readonly>
                    <option value="1">Aprovado</option>
                </select>
            </div>   
            
            <div class="form-group col-md-6">
                <label for="telAgenda">Contato</label>
                <input type="text" class="form-control" id="telAgenda" name="telAgenda" required autocomplete="off"
                    value="<?=$telAgenda?>" readonly>
            </div>
            <div class="form-group col-md-6">
             <!--  Foi inserido Responsavel na agenda na versão 1.7.29 -->
             <label for="resp">Responsável</label>
            <select class="form-control" id="resp" name="resp">
                <?php
                $sqluser = "SELECT * FROM usuario ORDER BY Nome ASC";
                $usuario = mysqli_query($conexao, $sqluser);
                while ($array = mysqli_fetch_array($usuario, MYSQLI_ASSOC)) {
                    $IdUsuario = $array["IdUsuario"];
                    $nome = $array["Nome"];
                ?>
                    <option>
                        <?= $nome ?>
                    </option>
                <?php } ?>
            </select>
            <br>
        </div>
        <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Confirmar</button>
        <br>
        <br>
        <a href="aprovar_agendamento.php">Voltar</a>
        <?php } ?>
    </form>
</div>