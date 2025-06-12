<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
include_once('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de saída</title>
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

<body>
    <?php include_once('menu.php'); ?>
    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastrar Despesa</h4>
        <form action="inserir_saida.php" method="POST">
            <div class="form-group">
                <input type="hidden" class="form-control" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="quantos">Valor da despesa</label>
                <input type="number" class="form-control" id="quantos" placeholder="Digite o valor dessa despesa" name="quantos" step="0.01" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="descricao">Qual o motivo dessa despesa?</label>
                <textarea class="form-control" id="descricao" name="descricao" placeholder="Ex: Frete, Pagamento, etc.." autocomplete="off" required></textarea>
            </div>

            <div class="form-group">
                <label for="fmpag">Qual a forma de pagamento dessa Saída?</label>
                <input type="text" class="form-control" id="fmpag" name="fmpag" placeholder="Ex: Dinheiro, Cartão ou pix" autocomplete="off" required>
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
                        <option>
                            <?= $nome ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data">Qual a data dessa saída?</label>
                <input type="date" class="form-control" id="data" name="data" placeholder="Data da saída" required autocomplete="off">
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
                <input type="hidden" class="form-control" id="datareg" name="datareg">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="id_reg_delet" name="id_reg_delet">
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar</button>
            <a href="listar_saida.php" class="btn-enviar btn btn-success btn-sm btn-block">Ver saídas</a>
        </form>
    </div>
    <?php include_once('footer.php') ?>
</body>

</html>