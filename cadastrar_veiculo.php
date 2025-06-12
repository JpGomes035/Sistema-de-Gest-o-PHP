<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Veículo</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de Veículo</h4>
        <form action="inserir_veiculo.php" method="POST">
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" placeholder="Digite a marca do veículo" name="marca" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control" id="modelo" placeholder="Digite o modelo do veículo" name="modelo" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="ano">Ano</label>
                <input type="number" class="form-control" id="ano" placeholder="Digite o ano do veículo" name="ano" required>
            </div>
            <div class="form-group">
                <label for="cor">Cor</label>
                <input type="text" class="form-control" id="cor" placeholder="Digite a cor do veículo" name="cor" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="chassi">Chassi</label>
                <input type="text" class="form-control" id="chassi" placeholder="Digite o número do chassi" name="chassi" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="placa">Placa</label>
                <input type="text" class="form-control" id="placa" placeholder="Digite a placa do veículo" name="placa" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="valor_aquisicao">Valor de Aquisição</label>
                <input type="text" class="form-control" id="valor_aquisicao" placeholder="Digite o valor de aquisição do veículo" name="valor_aquisicao" required>
            </div>
            <div class="form-group">
                <label for="data_aquisicao">Data de Aquisição</label>
                <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao" required>
            </div>
            <div class="form-group">
                <label for="responsavel">Responsável</label>
                <input type="text" class="form-control" id="responsavel" placeholder="Digite o responsável pelo veículo" name="responsavel" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="localizacao">Localização</label>
                <input type="text" class="form-control" id="localizacao" placeholder="Digite a localização do veículo" name="localizacao" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="quilometragem">Quilometragem</label>
                <input type="number" class="form-control" id="quilometragem" placeholder="Digite a quilometragem atual do veículo" name="quilometragem" required>
            </div>
            <div class="form-group">
                <label for="condicao">Condição</label>
                <select class="form-control" id="condicao" name="condicao" required>
                    <option value="Bom">Bom</option>
                    <option value="Regular">Regular</option>
                    <option value="Precisa de reparos">Precisa de Reparos</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_veiculos.php" class="btn btn-success btn-sm btn-block">Listagem de Veículos</a>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>
