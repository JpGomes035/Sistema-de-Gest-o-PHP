<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
include_once('conexao.php');
//Cadastrar uma conta a receber 
?>
<!DOCTYPE html>
<html lang="en">

<title>Contas a Receber</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de contas a Receber</h4>
        <form action="inserir_contas_receber.php" method="POST">
        <div class="form-group">
                <input type="hidden" class="form-control" id="id_Contasreceber" name="id_Contasreceber">
            </div>
            <div class="form-group">
                <label for="numero_documento">Nº Documento:</label>
                <input type="number" class="form-control" id="numero_documento" placeholder="Digite o Numero do Documento"
                    name="numero_documento"  required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="descricao_pagar">Descrição:</label>
                <textarea name="descricao_venda" id="descricao_venda" class="form-control" required placeholder="Ex: Venda, recebimentos..." autocomplete="off"></textarea>
            </div>
            <div class="form-group">
                <label for="valor_parcela">Qual o valor da parcela?</label>
                <input type="number" class="form-control" id="valor_parcela" name="valor_parcela"
                    placeholder="Insira o Valor da Parcela" step="0.01"  autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="valor_venda">Qual o valor da Venda?</label>
                <input type="number" class="form-control" id="valor_venda" name="valor_venda"
                    placeholder="Insira o Valor total da Venda" step="0.01"  autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="valor_abatido">Qual o valor da abatido da Venda?</label>
                <input type="number" class="form-control" id="valor_abatido" name="valor_abatido"
                    placeholder="Insira o Valor abatido na Venda" step="0.01" autocomplete="off" >
            </div>
            <div class="form-group">
                <label for="data_venda">Qual a data dessa venda?</label>
                <input type="date" class="form-control" id="data_venda" name="data_venda"
                placeholder="Data da Venda" required autocomplete="off">
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
            <a href="listar_contas_receber.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver Contas a receber</a>
            <a href="listar_contas_recebidas.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver Contas recebidas</a>
            
        </form>
    </div>
    
    <?php include_once('footer.php') ?>
</body>

</html>