<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de Ordem de serviço</title>
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de ordem de serviços</h4>
        <form action="inserir_os.php" method="POST">
            <div class="form-group">
                <label for="responsavel">Usuário responsavel pela OS:</label>
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
                <label for="statusOs">Descrição da OS?</label>
                <input type="text" class="form-control" id="descricaoOs" placeholder="Ex: Foi solicitado a manutenção de um equipamento..." name="descricaoOs" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="data_inicioOs">Qual a data de inicio dessa OS?</label>
                <input type="date" class="form-control" id="data_inicioOs" name="data_inicioOs" placeholder="Data da entrada" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="valorOs">Orçamento dessa OS?</label>
                <input type="number" class="form-control" id="valorOs" placeholder="Digite o Orçamento da Ordem de Serviço." name="valorOs" step="0.01" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="tipoOs">Tipo da OS?</label>
                <div class="input-group"> <!-- Adiciona uma classe input-group -->
                    <select class="form-control" id="tipoOs" name="tipoOs" required autocomplete="off">
                        <option value="">Selecione o tipo de Ordem de Serviço</option>
                        <?php
                        $sqlServ = "SELECT * FROM tipo_servico ORDER BY nomeServico ASC";
                        $servico = mysqli_query($conexao, $sqlServ);
                        while ($array = mysqli_fetch_array($servico, MYSQLI_ASSOC)) {
                            $idServico = $array["idServico"];
                            $nomeServico = $array["nomeServico"];
                        ?>
                            <option value="<?= $nomeServico ?>"><?= $nomeServico ?></option>
                        <?php } ?>
                    </select>
                    <div class="input-group-append"> <!-- Adiciona um div para o botão com classe input-group-append -->
                        <button class="btn btn-outline-secondary" type="button" id="btnRedirect">
                            <i class="fa fa-plus" aria-hidden="true"></i> <!-- Adiciona o ícone "+" -->
                        </button>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById("btnRedirect").addEventListener("click", function() {
                    window.location.href = "cadastro_tiposervico.php";
                });
            </script>


            <div class="form-group">
                <label for="statusOs">Qual o Status dessa OS?</label>
                <input type="text" class="form-control" id="statusOs" placeholder="Ex: Está em fase de Análise" name="statusOs" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="nome">Nome do Cliente</label>
                <select class="form-control" id="clienteOs" name="clienteOs">
                    <?php
                    //puxar os cliente cadastrado
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
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="lista_os.php" class="btn-enviar btn btn-success btn-sm btn-block">OS em andamento</a>
            <a href="lista_os_finalizada.php" class="btn-enviar btn btn-success btn-sm btn-block">OS Finalizadas</a>
        </form>
    </div>


    <?php include_once('footer.php'); ?>
</body>

</html>