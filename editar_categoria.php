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
<title>Editar Categoria</title>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Categoria</h4>
    <form action="atualizar_categoria.php" method="POST">
        <?php
            $sql = "SELECT * FROM categoria WHERE IdCategoria = $id";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $idCategoria = $array['IdCategoria'];
                $nome = $array['Nome'];
                $catalogo = $array['catalogo'];

        ?>
        <input style="display:none" id="idCategoria" name="idCategoria" value="<?=$idCategoria?>">
        <div class="form-group">
            <label for="nomeCategoria">Nome Categoria</label>
            <input type="text" class="form-control" id="nomeCategoria" placeholder="Digite o nome da categoria"
                name="nomeCategoria" required autocomplete="off" value="<?=$nome?>">
        </div>
        <div class="form-group">
    <label for="catalogo">Adicionar ao catálogo:</label>
    <select name="catalogo" id="catalogo" class="form-control">
        <option value="s" <?= $catalogo == 's' ? 'selected' : '' ?>>Sim</option>
        <option value="n" <?= $catalogo == 'n' ? 'selected' : '' ?>>Não</option>
    </select>
</div>

        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>