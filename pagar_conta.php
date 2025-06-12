<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id_Contaspagar = $_GET['id_Contaspagar'];
?>

<head>
    <title>Confirmar Pagamento</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
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
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Pagar Conta</h4>
    <form action="atualizar_conta_paga.php" method="POST">
        <?php
        $sql = "SELECT * FROM contas_pagar WHERE id_Contaspagar = $id_Contaspagar";
        $retorno = mysqli_query($conexao, $sql);

        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $id_Contaspagar = $array['id_Contaspagar'];
            $numero_documento = $array['numero_documento'];
            $descricao_pagar = $array['descricao_pagar'];
            $valor_parcela = $array['valor_parcela'];
            $valor_compra = $array['valor_compra'];
            $valor_abatido = $array['valor_abatido'];
            $data_compra = $array['data_compra'];
            $valor_parcela = $array['valor_parcela'];
            $cliente = $array['cliente'];
            $data_vencimento = $array['data_vencimento'];
            ?>


            <input style="display:none" id="id_Contaspagar" name="id_Contaspagar" value="<?= $id_Contaspagar ?>">
            <div class="form-group">
                <label for="numero_documento">Nº Documento:</label>
                <input type="number" class="form-control" id="numero_documento" placeholder="Digite o Numero do Documento"
                    name="numero_documento" required autocomplete="off" value="<?= $numero_documento ?>">
            </div>
            <div class="form-group">
                <label for="valor_parcela">Qual o valor da parcela?</label>
                <input type="number" class="form-control" id="valor_parcela" name="valor_parcela"
                    placeholder="Insira o Valor da Parcela"step="0.01" autocomplete="off" required value="<?= $valor_parcela ?>">
            </div>
            <div class="form-group">
                <label for="valor_compra">Qual o valor da COMPRA?</label>
                <input type="number" class="form-control" id="valor_compra" name="valor_compra"
                    placeholder="Insira o Valor da Compra" step="0.01" autocomplete="off" required value="<?= $valor_compra ?>">
            </div>
            <div class="form-group">
                <label for="valor_abatido">Qual o valor da abatido da COMPRA?</label>
                <input type="number" class="form-control" id="valor_abatido" name="valor_abatido"
                    placeholder="Insira o Valor abatido na compra" step="0.01" autocomplete="off" value="<?= $valor_abatido ?>">
            </div>
            <div class="form-group">
                <label for="data_compra">Qual a data dessa Compra?</label>
                <input type="date" class="form-control" id="data_compra" name="data_compra" placeholder="Data da Compra"
                    required autocomplete="off" value="<?= $data_compra ?>">
            </div>
            <div class="form-group">
                <label for="data_vencimento">Qual a data de vencimento da parcela?</label>
                <input type="date" class="form-control" id="data_vencimento" name="data_vencimento"
                    placeholder="Data de vencimento" required autocomplete="off" value="<?= $data_vencimento ?>">
            </div>
            <div class="form-group">
                <label for="cliente">Cliente:</label>
                <input type="text" class="form-control" id="cliente" name="cliente"
                    placeholder="cliente"  autocomplete="off" required readonly
                    value="<?= $cliente ?>">
            </div>
            <div class="form-group">
                <label for="data_pagamento">Qual a data de pagamento dessa conta?</label>
                <input type="date" class="form-control" id="data_pagamento" name="data_pagamento"
                    placeholder="Data de Pagamento" required autocomplete="off">
            </div>
            <!-- <div class="form-group">
            <label for="agencia">Número da Agência:</label>
            <input type="text" class="form-control" id="agencia" placeholder="Número da agência" name="agencia" autocomplete="off" value="<?= $agencia ?>">
            <script>
    $(document).ready(function() {
      // Aplica a máscara no campo de número da agência
      $('#agencia').inputmask('9999');
    });
  </script>     
            </div>
            <div class="form-group">
                <label for="cc">Conta Corrente (C/C)</label>
                <input type="text" class="form-control" id="cc" placeholder="Digite a conta corrente" name="cc" required autocomplete="off" value="<?= $cc ?>">
                <script>
                $(document).ready(function() {
                 // Aplica a máscara no campo de conta corrente
                 $('#cc').inputmask('99999-9');
                });
            </script>
            </div>-->
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Pagar</button>
            <a href="listar_contas_pagar.php" class="btn-enviar btn btn-primary btn-sm btn-block">Cancelar</a>
        <?php } ?>
    </form>
</div>