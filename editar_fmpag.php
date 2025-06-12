<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id_fmpag = $_GET['id_fmpag'];
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
<title>Editar forma de Pagamento</title>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Forma de Pagamento</h4>
    <form action="atualizar_fmpag.php" method="POST">
        <?php
        $sql = "SELECT * FROM fm_pag WHERE id_fmpag = $id_fmpag";
        $retorno = mysqli_query($conexao, $sql);

        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $id_fmpag = $array['id_fmpag'];
            $nome_fmpag = $array['nome_fmpag'];
            $banco_vinculado = $array['banco_vinculado'];
            $percentual_taxa = $array['percentual_taxa'];
        ?>
            <input type="hidden" id="id_fmpag" name="id_fmpag" value="<?= $id_fmpag ?>">
            <div class="form-group">
                <label for="nomeCategoria">Nome Forma de Pagamento</label>
                <input type="text" class="form-control" id="nome_fmpag" placeholder="Digite o nome da Forma de Pagamento"
                    name="nome_fmpag" required autocomplete="off" value="<?= $nome_fmpag ?>">
            </div>
            <div class="form-group">
                <label for="banco_vinculado">Vincular alguma Conta/Banco nessa forma de pagamento? </label>
                <select class="form-control" id="banco_vinculado" name="banco_vinculado">
                    <?php
                    $sqlnome = "SELECT * FROM banco ORDER BY nomeBanco ASC";
                    $retornonome = mysqli_query($conexao, $sqlnome);
                    while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                        $idBanco = $array["idBanco"];
                        $nomeBanco = $array["nomeBanco"];
                    ?>
                        <option <?= ($nomeBanco == $banco_vinculado) ? 'selected' : ''; ?>><?= $nomeBanco ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="percentual_taxa">Percentual da Taxa (apenas para cartões): </label>
                <input type="number" step="0.01" class="form-control" id="percentual_taxa" 
                    placeholder="Digite o percentual da taxa, se houver" name="percentual_taxa" 
                    value="<?= $percentual_taxa ?>">
            </div>
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>