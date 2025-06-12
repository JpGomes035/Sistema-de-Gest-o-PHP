<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id = $_GET['id'];
?>
<head>
    <title>Editar cliente</title>
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
        font-weight: bold;
        justify-content: center;
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
</head>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Editar Cliente</h4>
    <form action="atualizar_cliente.php" method="POST">
        <?php
            $sql = "SELECT * FROM cliente WHERE idCliente = $id";
            $retorno = mysqli_query($conexao,$sql);

            while($array = mysqli_fetch_array($retorno,MYSQLI_ASSOC)){
                $idCliente = $array['idCliente'];
                $nomeCliente = $array['nomeCliente'];
                $numeroCliente = $array['numeroCliente'];
                $emailCliente = $array['emailCliente'];
                $cepCliente = $array['cepCliente'];
                $cpfCliente = $array['cpfCliente'];
        ?>
        <input style="display:none" id="idCliente" name="idCliente" value="<?=$idCliente?>">
        <div class="form-group">
            <label for="nomeCliente">Nome do Cliente</label>
            <input type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome do cliente"
                name="nomeCliente" required autocomplete="off" value="<?=$nomeCliente?>">
        </div>
        <div class="form-group">
                <label for="numero">Qual o número do cliente?</label>
                <input type="text" class="form-control" id="numeroCliente" name="numeroCliente"
                    placeholder="Ex: 35 98888-8888" autocomplete="off" maxlength="11" value="<?=$numeroCliente?>">
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
  var telefoneInput = document.getElementById('numeroCliente');
  telefoneInput.value = formatarTelefone(telefoneInput.value);
}

// Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
document.getElementById('numeroCliente').addEventListener('input', aplicarMascaraTelefone);
</script>
            </div>
            <div class="form-group">
                <label for="emailCliente">Qual o email novo do cliente?</label>
                <input type="text" class="form-control" id="emailCliente" name="emailCliente"
                    placeholder="Ex: exemplo@gmail.com" autocomplete="off"required value="<?=$emailCliente?>">
            </div>
            <div class="form-group">
                <label for="cep">Qual o cep do cliente?</label>
                <input type="text" class="form-control" id="cepCliente" name="cepCliente"
                    placeholder="Ex: 64077-160" autocomplete="off" maxlength="8" value="<?=$cepCliente?>" maxlength="9">
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
  var cepInput = document.getElementById('cepCliente');
  cepInput.value = formatarCEP(cepInput.value);
}

// Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de CEP
document.getElementById('cepCliente').addEventListener('input', aplicarMascaraCEP);
</script>
            </div>
            <div class="form-group">
        <label>CPF do Cliente:</label>
        <input class="form-control" type="text" id="cpfCliente" name="cpfCliente"
        placeholder="Insira o CPF do Cliente" oninput="formatarCPF(this)" maxlength="11" value="<?=$cpfCliente?>" />
    </div>

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
        <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        <?php } ?>
    </form>
</div>