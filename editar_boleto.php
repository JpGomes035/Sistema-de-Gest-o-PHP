<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once 'head.php';
$idBoleto = $_GET['id'];

$sql = "SELECT * FROM boletos WHERE id_boleto = $idBoleto";
$retorno = mysqli_query($conexao, $sql);

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
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Formulário de Atualização de Boleto</h4>
    <form action="atualizar_boleto.php" method="POST">
        <?php
        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $idBoleto = $array['id_boleto'];
            $numeroBoleto = $array['numero_boleto'];
            $valor = $array['valor'];
            $dataEmissao = $array['data_emissao'];
            $dataVencimento = $array['data_vencimento'];
            $beneficiario = $array['beneficiario'];
            $pagadorNome = $array['pagador_nome'];
            $pagadorCPF = $array['pagador_cpf'];
            $statusPagamento = $array['status_pagamento'];
        ?>
            <input style="display:none" id="idBoleto" name="idBoleto" value="<?= $idBoleto ?>">
            <div class="form-group">
                <label for="numeroBoleto">Número do Boleto</label>
                <input type="text" class="form-control" id="numeroBoleto" placeholder="Digite o número do boleto" name="numeroBoleto" required autocomplete="off" value="<?= $numeroBoleto ?>">
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="text" class="form-control" id="valor" placeholder="Digite o valor do boleto" name="valor" required autocomplete="off" value="<?= $valor ?>">
            </div>
            <div class="form-group">
                <label for="dataEmissao">Data de Emissão</label>
                <input type="date" class="form-control" id="dataEmissao" name="dataEmissao" required value="<?= $dataEmissao ?>">
            </div>
            <div class="form-group">
                <label for="dataVencimento">Data de Vencimento</label>
                <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" required value="<?= $dataVencimento ?>">
            </div>
            <div class="form-group">
                <label for="beneficiario">Beneficiário</label>
                <input type="text" class="form-control" id="beneficiario" placeholder="Digite o nome do beneficiário" name="beneficiario" required autocomplete="off" value="<?= $beneficiario ?>">
            </div>
            <div class="form-group">
                <label for="pagadorNome">Nome do Pagador</label>
                <input type="text" class="form-control" id="pagadorNome" placeholder="Digite o nome do pagador" name="pagadorNome" required autocomplete="off" value="<?= $pagadorNome ?>">
            </div>
            <div class="form-group">
                <label for="pagadorCPF">CPF do Pagador</label>
                <input type="text" class="form-control" id="pagadorCPF" placeholder="Digite o CPF do pagador" name="pagadorCPF" required autocomplete="off" value="<?= $pagadorCPF ?>">
            </div>
            <div class="form-group">
                <label for="statusPagamento">Status do Pagamento</label>
                <select id="statusPagamento" class="form-control" name="statusPagamento">
                    <option value="Pago" <?= $statusPagamento == 'Pago' ? 'selected' : '' ?>>Pago</option>
                    <option value="Pendente" <?= $statusPagamento == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="Vencido" <?= $statusPagamento == 'Vencido' ? 'selected' : '' ?>>Vencido</option>
                    <option value="Recebido" <?= $statusPagamento == 'Recebido' ? 'selected' : '' ?>>Recebido</option>
                </select>
            </div>
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>
