<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de Boleto</title>
<style>
    body {
        background: linear-gradient(to bottom, #4daaaa, #a7a4a4);
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
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Insira as informações do Boleto</h4>
        <form action="inserir_boleto.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" class="form-control" id="id_boleto" name="id_boleto">

                <label for="numero_boleto">Número do Boleto:</label>
                <input type="text" class="form-control" id="numero_boleto" name="numero_boleto"
                    placeholder="Insira o Nº do Boleto" required>

                <label for="valor">Valor do Boleto:</label>
                <input type="number" id="valor" class="form-control" name="valor" step="0.01"
                    placeholder="Insira o Valor do Boleto" required>

                <label for="data_emissao">Data de Emissão:</label>
                <input type="date" id="data_emissao" name="data_emissao" class="form-control"
                    placeholder="Insira a data de Emissão" required>

                <label for="data_vencimento">Data de Vencimento:</label>
                <input type="date" id="data_vencimento" class="form-control" name="data_vencimento"
                    placeholder="Insira a data de Vencimento" required>

                <label for="beneficiario">Beneficiário:</label>
                <input type="text" id="beneficiario" name="beneficiario" class="form-control"
                    placeholder="Insira o beneficiario do Boleto" required>

                <label for="pagador_nome">Nome do Pagador:</label>
                <input type="text" id="pagador_nome" name="pagador_nome" class="form-control"
                    placeholder="Insira o Nome do PAGADOR" required>

                <label for="pagador_cpf">CPF do Pagador:</label>
                <input type="text" id="pagador_cpf" name="pagador_cpf" class="form-control"
                    placeholder="Insira o CPF do pagador" oninput="formatarCPF(this)" maxlength="11" required>
                <script>
                    function formatarCPF(input) {
                        // Remove todos os caracteres não numéricos
                        var cpf = input.value.replace(/\D/g, '');

                        // Adiciona pontos e traço de formatação
                        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

                        // Atualiza o valor do campo de entrada
                        input.value = cpf;
                    }
                </script>
                <label for="status_pagamento">Status do Pagamento:</label>
                <select id="status_pagamento" class="form-control" name="status_pagamento">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Vencido">Vencido</option>
                    <option value="Recebido">Recebido</option>
                </select>
                <label for="arquivo_boleto">Arquivo do Boleto:</label>
                <input type="file" id="arquivo_boleto" name="arquivo_boleto" class="form-control" required>

                <br>
                <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
                <a href="listar_boleto.php" class="btn-enviar btn btn-success btn-sm btn-block">Listagem de Boletos</a>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>