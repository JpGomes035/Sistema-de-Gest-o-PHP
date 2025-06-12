<?php 
include_once 'iniciar_sessao.php';
include_once('head.php');
include_once('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Contas a Pagar</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de contas a Pagar</h4>
        <form action="inserir_contas_pagar.php" method="POST">
        <div class="form-group">
                <input type="hidden" class="form-control" id="id_Contaspagar" name="id_Contaspagar">
            </div>
            <div class="form-group">
                <label for="numero_documento">Nº Documento:</label>
                <input type="number" class="form-control" id="numero_documento" placeholder="Digite o Numero do Documento"
                    name="numero_documento"  required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="descricao_pagar">Descrição:</label>
                <textarea name="descricao_pagar" id="descricao_pagar" class="form-control" required placeholder="Ex: Despesas, pagamentos..." autocomplete="off"></textarea>
            </div>
            <div class="form-group">
                <label for="valor_parcela">Qual o valor da parcela?</label>
                <input type="number" class="form-control" id="valor_parcela" name="valor_parcela"
                    placeholder="Insira o Valor da Parcela" step="0.01" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="valor_compra">Qual o valor da COMPRA?</label>
                <input type="number" class="form-control" id="valor_compra" name="valor_compra"
                    placeholder="Insira o Valor total da Compra" step="0.01" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="valor_abatido">Qual o valor da abatido da COMPRA?</label>
                <input type="number" class="form-control" id="valor_abatido" name="valor_abatido"
                    placeholder="Insira o Valor abatido na compra" step="0.01" autocomplete="off" >
            </div>
            <div class="form-group">
                <label for="data_compra">Qual a data dessa Compra?</label>
                <input type="date" class="form-control" id="data_compra" name="data_compra"
                placeholder="Data da Compra" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="data_vencimento">Qual a data de vencimento da parcela?</label>
                <input type="date" class="form-control" id="data_vencimento" name="data_vencimento"
                placeholder="Data de vencimento" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="cliente">Cliente:</label>
                <select class="form-control" id="cliente" name="cliente">
                <?php
                $sqlnome = "SELECT * FROM cliente ORDER BY nomeCliente ASC";
                $retornonome = mysqli_query($conexao,$sqlnome);
                while($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)){
                    $idCliente = $array["idCliente"];
                    $nomeCliente = $array["nomeCliente"];
                ?>
                <option><?=$nomeCliente?></option>
                <?php }?>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="status" name="status">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro">
            </div>
            
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar</button>
            <a href="listar_contas_pagar.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver Contas a pagar</a>
            <a href="listar_contas_pagas.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver Contas Pagas</a>
            
        </form>
    </div>
    
    <?php include_once('footer.php') ?>
</body>

</html>