<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de Forma pag</title>
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
<form action="inserir_fmpag.php" method="POST">
    <div class="form-group">
        <label for="nome_fmpag">Forma de Pagamento: </label>
        <input type="text" class="form-control" id="nome_fmpag" placeholder="Digite o nome da Forma de Pagamento" name="nome_fmpag" required autocomplete="off">
    </div>

    <div class="form-group">
        <label for="banco_vinculado">Vincular alguma Conta/Banco nessa forma de pagamento? </label>
        <select class="form-control" id="banco_vinculado" name="banco_vinculado">
            <option value="">Selecione uma conta/banco</option>
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
        <label for="percentual_taxa">Percentual da Taxa (apenas para cartões): </label>
        <input type="number" step="0.01" class="form-control" id="percentual_taxa" placeholder="Digite o percentual da taxa, se houver" name="percentual_taxa">
    </div>

    <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
    <a href="listar_formpag.php" class="btn-enviar btn btn-success btn-sm btn-block">Listar formas de pagamento</a>
</form>



<?php include_once('footer.php'); ?>
</body>

</html>