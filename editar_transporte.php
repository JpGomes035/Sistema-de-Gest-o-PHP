<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');

$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Transporte</title>
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

<body>

    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Transporte</h4>
        <form action="atualizar_transporte.php" method="POST">
            <?php
            $sql = "SELECT * FROM transportes WHERE id = $id";
            $retorno = mysqli_query($conexao, $sql);

            while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                $idTransporte = $array['id'];
                $pedido_id = $array['pedido_id'];
                $tipo_pedido = $array['tipo_pedido'];
                $valor_transporte = $array['valor_transporte'];
                $veiculo_placa = $array['veiculo_placa'];
                $data_transporte = $array['data_transporte'];
                $Concluido = $array['Concluido'];
                ?>
                <input style="display:none" id="idTransporte" name="idTransporte" value="<?= $idTransporte ?>">
                <div class="form-group">
                    <label for="pedido_id">Código do Pedido</label>
                    <input type="text" class="form-control" id="pedido_id" placeholder="Digite o Código do pedido ex: 07"
                        name="pedido_id" required autocomplete="off" value="<?= $pedido_id ?>">
                </div>
                <div class="form-group">
                    <label for="tipo_pedido">Tipo de Pedido</label>
                    <select class="form-control" id="tipo_pedido" name="tipo_pedido" required>
                        <option value="Compra" <?= $tipo_pedido == 'Compra' ? 'selected' : '' ?>>Compra</option>
                        <option value="Venda" <?= $tipo_pedido == 'Venda' ? 'selected' : '' ?>>Venda</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valor_transporte">Valor Total do Transporte</label>
                    <input type="number" class="form-control" id="valor_transporte"
                        placeholder="Digite o valor total do transporte" name="valor_transporte" required step="0.01"
                        value="<?= $valor_transporte ?>">
                </div>
                <div class="form-group">
                    <label for="veiculo_placa">Placa do Veículo</label>
                    <input type="text" class="form-control" id="veiculo_placa" placeholder="Digite a placa do veículo"
                        name="veiculo_placa" required autocomplete="off" value="<?= $veiculo_placa ?>">
                </div>
                <div class="form-group">
                    <label for="data_transporte">Data de Transporte</label>
                    <input type="date" class="form-control" id="data_transporte" name="data_transporte" required
                        value="<?= $data_transporte ?>">
                </div>
                <div class="form-group">
                    <label for="concluido">Novo status do Transporte <B>*ATENÇÃO*</B></label>
                    <select class="form-control" id="Concluido" name="Concluido" required>
                        <option value="Em rota" <?= $Concluido == 'Em rota' ? 'selected' : '' ?>>Em rota</option>
                        <option value="Concluído" <?= $Concluido == 'Concluído' ? 'selected' : '' ?>>Concluído</option>
                    </select>
                    <br>
                    Status Atual do TRANSPORTE: 
                    <span style="color: <?= $Concluido == 'Concluido' ? 'blue' : 'red' ?>">
                    <?= $Concluido ?>
                    </span>
                </div>
            <?php } ?>
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        </form>
    </div>
</body>

</html>