<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');

$id = $_GET['id'];
?>
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
<title>Editar Veículo</title>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Veículo</h4>
    <form action="atualizar_veiculo.php" method="POST">
        <?php
            $sql = "SELECT * FROM veiculos WHERE id = $id";
            $retorno = mysqli_query($conexao, $sql);

            while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                $id = $array['id'];
                $marca = $array['marca'];
                $modelo = $array['modelo'];
                $ano = $array['ano'];
                $cor = $array['cor'];
                $placa = $array['placa'];
                $quilometragem = $array['quilometragem'];
                $condicao = $array['condicao'];

        ?>
        <input style="display:none" id="id" name="id" value="<?= $id ?>">

        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca do veículo" value="<?= $marca ?>">
        </div>
        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo do veículo" value="<?= $modelo ?>">
        </div>
        <div class="form-group">
            <label for="ano">Ano</label>
            <input type="text" class="form-control" id="ano" name="ano" placeholder="Ano do veículo" value="<?= $ano ?>">
        </div>
        <div class="form-group">
            <label for="cor">Cor</label>
            <input type="text" class="form-control" id="cor" name="cor" placeholder="Cor do veículo" value="<?= $cor ?>">
        </div>
        <div class="form-group">
            <label for="placa">Placa</label>
            <input type="text" class="form-control" id="placa" name="placa" placeholder="Placa do veículo" value="<?= $placa ?>">
        </div>
        <div class="form-group">
            <label for="km">Quilometragem</label>
            <input type="text" class="form-control" id="quilometragem" name="quilometragem" placeholder="Quilometragem do veículo" value="<?= $quilometragem ?>">
        </div>
        <div class="form-group">
                <label for="condicao">Condição</label>
                <select class="form-control" id="condicao" name="condicao" required value="<?= $condicao ?>">
                    <option value="Bom">Bom</option>
                    <option value="Regular">Regular</option>
                    <option value="Precisa de reparos">Precisa de Reparos</option>
                </select>
            </div>
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>
