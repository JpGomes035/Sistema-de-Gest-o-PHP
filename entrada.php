<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
include_once('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de entrada</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Entrada</h4>
        <form action="inserir_entrada.php" method="POST">
            <div class="form-group">
                <input type="hidden" class="form-control" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="quantos">Entrada de renda</label>
                <input type="number" class="form-control" id="quantos" placeholder="Digite o valor da entrada"
                    name="quantos" step="0.01" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="descricao">Qual o motivo dessa entrada?</label>
                <textarea name="descricao" id="descricao" class="form-control" required placeholder="Ex: Receber algo por fora do sistema, etc..." autocomplete="off"></textarea>

            </div>
            <div class="form-group">
                <label for="fmpag">Qual a forma de pagamento dessa entrada?</label>
                <select class="form-control" id="fmpag" name="fmpag">
                    <?php
                    $sqlnome = "SELECT * FROM fm_pag WHERE deletado = 'N' ORDER BY nome_fmpag";
                    $retornonome = mysqli_query($conexao, $sqlnome);
                    while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                        $id_fmpag  = $array["id_fmpag "];
                        $nome_fmpag = $array["nome_fmpag"];
                    ?>
                        <option><?= $nome_fmpag ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="responsavel">Usuário responsavel:</label>
                <select class="form-control" id="responsavel" name="responsavel">
                    <?php
                    $sqluser = "SELECT * FROM usuario ORDER BY Nome ASC";
                    $usuario = mysqli_query($conexao, $sqluser);
                    while ($array = mysqli_fetch_array($usuario, MYSQLI_ASSOC)) {
                        $IdUsuario = $array["IdUsuario"];
                        $nome = $array["Nome"];
                    ?>
                        <option><?= $nome ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nome">Nome do Cliente</label>
                <select class="form-control" id="nome" name="nome">
                    <?php
                    $sqlnome = "SELECT * FROM cliente ORDER BY nomeCliente ASC";
                    $retornonome = mysqli_query($conexao, $sqlnome);
                    while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                        $idCliente = $array["idCliente"];
                        $nomeCliente = $array["nomeCliente"];
                    ?>
                        <option><?= $nomeCliente ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="banco">Qual o banco responsavel?</label>
                <select class="form-control" id="nomeBanco" name="nomeBanco">
                    <?php
                    $sqlnome = "SELECT * FROM banco ORDER BY nomeBanco ASC";
                    $retornonome = mysqli_query($conexao, $sqlnome);
                    while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                        $idBanco = $array["idBanco"];
                        $nomeBanco = $array["nomeBanco"];
                    ?>
                        <option><?= $nomeBanco ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data">Qual a data dessa entrada?</label>
                <input type="date" class="form-control" id="data" name="data"
                    placeholder="Data da entrada" required autocomplete="off">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="datareg" name="datareg">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="id_reg" name="id_reg">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="deletado" name="deletado">
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar</button>
            <a href="listar_entrada.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver entradas</a>

        </form>
    </div>

    <?php include_once('footer.php') ?>
</body>

</html>