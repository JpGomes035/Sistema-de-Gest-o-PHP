<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id_Contasreceber = $_GET['id_Contasreceber'];

?>
<head>
    <title>Estornar recebimento</title>
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
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Estornar recebimento</h4>
    <form action="atualizar_estorno_recebimento.php" method="POST">
        <?php
            $sql = "SELECT * FROM contas_receber WHERE id_Contasreceber = $id_Contasreceber";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $id_Contasreceber = $array['id_Contasreceber'];
                $numero_documento = $array['numero_documento'];
                $descricao_venda = $array['descricao_venda'];
                $valor_parcela = $array['valor_parcela'];
                $valor_venda= $array['valor_venda'];
                $valor_abatido = $array['valor_abatido'];
                $data_venda = $array['data_venda'];
                $valor_parcela = $array['valor_parcela'];
                $data_vencimento = $array['data_vencimento'];
                
        ?>


        <input style="display:none" id="id_Contasreceber" name="id_Contasreceber" value="<?=$id_Contasreceber?>">
        <div class="form-group">
            <label for="numero_documento">Nº Documento:</label>
            <input type="number" class="form-control" id="numero_documento" placeholder="Digite o Numero do Documento"
            name="numero_documento"  required autocomplete="off" value="<?=$numero_documento?>" >
        </div>
        <div class="form-group">
                <label for="valor_parcela">Qual o valor da parcela?</label>
                <input type="text" class="form-control" id="valor_parcela" name="valor_parcela"
                    placeholder="Insira o Valor da Parcela" autocomplete="off" required value="<?=$valor_parcela?>">
            </div>
        <div class="form-group">
                <label for="valor_venda">Qual o valor da venda?</label>
                <input type="text" class="form-control" id="valor_venda" name="valor_venda"
                placeholder="Insira o Valor total da Venda" autocomplete="off" required value="<?=$valor_venda?>">
        </div> 
        <div class="form-group">
                <label for="valor_abatido">Qual o valor da abatido da Venda?</label>
                <input type="text" class="form-control" id="valor_abatido" name="valor_abatido"
                placeholder="Insira o Valor abatido na Venda" autocomplete="off" value="<?=$valor_abatido?>">
        </div>
        <div class="form-group">
                <label for="data_venda">Qual a data dessa Venda?</label>
                <input type="date" class="form-control" id="data_venda" name="data_venda"
                placeholder="Data da Venda" required autocomplete="off" value="<?=$data_venda?>">
            </div>
            <div class="form-group">
                <label for="data_vencimento">Qual a data de vencimento da parcela?</label>
                <input type="date" class="form-control" id="data_vencimento" name="data_vencimento"
                placeholder="Data de vencimento" required autocomplete="off" value="<?=$data_vencimento?>">
            </div>
           
            
            <input style="display:none" id="status" name="status">
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Estornar</button>
        <a href="listar_contas_recebidas.php" class="btn-enviar btn btn-primary btn-sm btn-block">Cancelar estorno</a>
        <?php } ?>
    </form>
</div>