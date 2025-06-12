<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Transporte</title>
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
</head>

<body>


    <?php include_once('menu.php'); ?>
    <br><br>
    <div style="padding:20px 0;max-width:800px" class="container">
        <h4>Cadastro de Transporte</h4>
        <h6 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom"><b>Você pode completar o cadastro na listagem após inserir as informações abaixo </b></h6>
        <form action="inserir_transporte.php" method="POST">
            <div class="form-group">
                <label for="pedido_id">Código do Pedido</label>
                <input type="text" class="form-control" id="pedido_id" placeholder="Digite o Código do pedido ex: 07"
                    name="pedido_id" required>
            </div>
            <div class="form-group">
                <label for="tipo_pedido">Tipo de Pedido</label>
                <select class="form-control" id="tipo_pedido" name="tipo_pedido" required>
                    <option value="Compra">Compra</option>
                    <option value="Venda">Venda</option>
                </select>
            </div>           
            <div class="form-group">
                <label for="valor_transporte">Valor Total do Transporte</label>
                <input type="number" class="form-control" id="valor_transporte"
                    placeholder="Digite o valor total do transporte" name="valor_transporte" required step="0.01">
            </div>
            <div class="form-group">
                <label for="veiculo_placa">Placa do Veículo (somente Veículos cadastrados no sistema)</label>
                <select class="form-control" id="veiculo_placa" name="veiculo_placa" required>
                    <?php
                    //puxar todas as categorias cadastradas
                    $sqlPlaca = "SELECT * FROM veiculos ORDER BY placa ASC";
                    $retornoPlaca = mysqli_query($conexao, $sqlPlaca);
                    while ($array = mysqli_fetch_array($retornoPlaca, MYSQLI_ASSOC)) {
                        $idVeiculo = $array["id"];
                        $placa = $array["placa"];
                        ?>
                        <option value="<?= $placa ?>">
                            <?= $placa ?>
                        </option>
                    <?php } ?>
                </select>
            </div>           
            <div class="form-group">
                <label for="data_cadastro_transporte">Datetime registration (Não alterável)</label>
                <input type="datetime-local" class="form-control" id="data_cadastro_transporte"
                    name="data_cadastro_transporte" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="concluido">Status do Transporte</label>
                <select class="form-control" id="concluido" name="concluido" required>
                    <option value="Em rota">Em rota</option>
                    <option value="Concluido">Concluído</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus"
                    aria-hidden="true"></i></button>
            <a href="listar_transportes.php" class="btn btn-success btn-sm btn-block">Listagem de Transportes</a>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>