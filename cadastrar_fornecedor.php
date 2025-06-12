<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<title>Cadastro de Fornecedor</title>
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
        font-weight: bold;
        font-size: 24px;
    }

    p {
        font-size: 16px;
        font-weight: bold;
        line-height: 1.6;
    }
</style>
</head>
<body>
    <?php include_once('menu.php'); ?>


    <div style="padding:20px 0;max-width:800px" class="container">
        <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de Fornecedor</h4>
        <form action="inserir_fornecedor.php" method="POST">
        <div class="form-group">
                <input type="hidden" class="form-control" id="IdFornecedor" name="IdFornecedor">
            </div>
            <div class="form-group">
                <label for="numeroProduto">Nome do Fornecedor</label>
                <input type="text" class="form-control" id="nomeForn" placeholder="Digite o nome do fornecedor"
                name="nomeForn" required autocomplete="off">
            </div>
            <div class="form-group">
            <label for="cnpjForn">CNPJ do Fornecedor</label>
            <input type="text" class="form-control cnpj-mask" id="cnpjForn" placeholder="Ex: 82.692.250/0001-02"
                name="cnpjForn" required autocomplete="off">
                    <script>
        // Máscara de CNPJ
        $(document).ready(function() {
            $('.cnpj-mask').inputmask('99.999.999/9999-99');
        });
    </script>
    <div class="form-group">
                <label for="numero">Qual o número do fornecedor?</label>
                <input type="text" class="form-control" id="telefoneForn" name="telefoneForn"
                    placeholder="Ex: 35 8888-8888, sem o numero '9'" autocomplete="off" maxlength="12">
                    <script>
// Função para formatar o telefone
function formatarTelefone(telefone) {
  // Remove todos os caracteres que não são números
  telefone = telefone.replace(/\D/g, '');

  // Verifica se o telefone possui 10 ou 11 dígitos
  if (telefone.length === 10 || telefone.length === 11) {
    // Aplica a máscara com o formato +55 (XX) XXXXX-XXXX
    telefone = telefone.replace(/(\d{2})(\d{4,5})(\d{4})/, '+55 ($1) $2-$3');
  }

  return telefone;
}

// Função para aplicar a máscara quando o campo de telefone for preenchido
function aplicarMascaraTelefone() {
  var telefoneInput = document.getElementById('telefoneForn');
  telefoneInput.value = formatarTelefone(telefoneInput.value);
}

// Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
document.getElementById('telefoneForn').addEventListener('input', aplicarMascaraTelefone);
</script>
            </div>
            <div class="form-group">
                <label for="cep">Qual o cep do fornecedor?</label>
                <input type="text" class="form-control" id="cepForn" name="cepForn"
                    placeholder="Ex: 64077-160" autocomplete="off" maxlength="9">
                    <script>// Função para formatar o CEP
function formatarCEP(cep) {
  // Remove todos os caracteres que não são números
  cep = cep.replace(/\D/g, '');

  // Verifica se o CEP possui 8 dígitos
  if (cep.length === 8) {
    // Aplica a máscara
    cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');
  }

  return cep;
}

// Função para aplicar a máscara quando o campo de CEP for preenchido
function aplicarMascaraCEP() {
  var cepInput = document.getElementById('cepForn');
  cepInput.value = formatarCEP(cepInput.value);
}

// Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de CEP
document.getElementById('cepForn').addEventListener('input', aplicarMascaraCEP);
</script>
            </div>
            <div class="form-group">
                <label for="email">Qual o email do Fornecedor?</label>
                <input type="email" class="form-control" id="emailForn" name="emailForn"
                    placeholder="Ex: exemplo@gmail.com" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="cod_Forn">Qual o Código do Fornecedor?</label>
                <input type="text" class="form-control" id="cod_Forn" name="cod_Forn"
                    placeholder="Insira aqui o código do fornecedor caso tenha." autocomplete="off">
            </div>
            </div>
            <button type="submit" class="btn-enviar btn btn-success btn-sm btn-block">Cadastrar  <i class="fa fa-plus" aria-hidden="true"></i></button>
            <a href="listar_fornecedor.php" class="btn-enviar btn btn-success btn-sm btn-block">Listagem de Fornecedores</a>
        </form>
    </div>


    <?php include_once('footer.php'); ?>
</body>

</html>