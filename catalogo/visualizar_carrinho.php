<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <link rel="stylesheet" href="style_carrinho.css">
    <title>Seu Carrinho</title>
</head>

<body>
    <div class="header">
        <h1>Seu Carrinho</h1>
    </div>

    <div class="container">
        <?php

        include('../conexao.php'); // Inclua o arquivo de conexão com o banco de dados

        // Lida com ações de diminuir ou remover itens do carrinho
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && isset($_POST['id'])) {
            $acao = $_POST['acao'];
            $id = $_POST['id'];

            if ($acao === 'diminuir') {
                foreach ($_SESSION['carrinho'] as $key => $produto) {
                    if ($produto['id'] == $id) {
                        if (isset($_SESSION['carrinho'][$key]['quantidade']) && $_SESSION['carrinho'][$key]['quantidade'] > 1) {
                            $_SESSION['carrinho'][$key]['quantidade']--;
                        } else {
                            unset($_SESSION['carrinho'][$key]);
                        }
                        break;
                    }
                }
            } elseif ($acao === 'remover') {
                foreach ($_SESSION['carrinho'] as $key => $produto) {
                    if ($produto['id'] == $id) {
                        unset($_SESSION['carrinho'][$key]);
                        break;
                    }
                }
            }

            // Reorganiza o array do carrinho
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

            // Recarrega a página para atualizar o carrinho
            header("Location: " . $_SERVER['PHP_SELF']);
            ob_end_flush();
            exit();
        }

        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
            $produtos = [];
            $produtos_mensagem = "";
            $total = 0; // Inicializa a variável para o valor total do carrinho

            // Agrupa produtos com base no ID e conta a quantidade
            foreach ($_SESSION['carrinho'] as $produto) {
                $id = $produto['id'];
                $nome = $produto['nome'];
                $preco = $produto['preco'];
                $quantidadeSolicitada = $produto['quantidade'];

                if (!isset($produtos[$id])) {
                    $produtos[$id] = [
                        'nome' => $nome,
                        'preco' => $preco,
                        'quantidade' => 0
                    ];
                }
                $produtos[$id]['quantidade'] += $quantidadeSolicitada;
            }

            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Exibe produtos agrupados
            foreach ($produtos as $id => $produto) {
                $preco = floatval($produto['preco']); // Converte para float
                $quantidade = $produto['quantidade'];
                $total += $preco * $quantidade; // Calcula o total
                $produtos_mensagem .= "ID - {$id} {$produto['nome']} - R$ {$preco} - QUANTIDADE: {$quantidade}\n";
                echo "<tr>
                        <td>{$id}</td>
                        <td>{$produto['nome']}</td>
                        <td>R$ {$preco}</td>
                        <td>{$quantidade}</td>
                        <td>
                            <form action='' method='post' style='display:inline-block;'>
                                <input type='hidden' name='acao' value='diminuir'>
                                <input type='hidden' name='id' value='{$id}'>
                                <button type='submit' class='acao-btn'>--</button>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</tbody></table>";
            echo "<div class='total'>
            <h3>Total do Carrinho: R$ " . number_format($total, 2, ',', '.') . "</h3>
            <input type='hidden' id='total' value='" . number_format($total, 2, ',', '.') . "'>
          </div>";

            // Recupera as informações da empresa
            $sql = "SELECT telefone FROM informacoes";
            $resultado = $conexao->query($sql);

            if ($resultado->num_rows > 0) {
                $array = $resultado->fetch_assoc();
                $telefone = $array["telefone"];
            }

            // Formata o telefone
            $telefone_formatado = preg_replace('/[^0-9]/', '', $telefone);

            // Formulário para escolher a forma de pagamento
            echo "<form id='form-pagamento'>
                    <label for='forma_pagamento'>Forma de Pagamento:</label>
                    <select name='forma_pagamento' id='forma_pagamento' required>
                        <option value='' disabled selected>Escolha uma forma de pagamento</option>";

            // Assumindo que você já tem uma consulta para buscar as formas de pagamento disponíveis
            $retorno_pag = $conexao->query("SELECT nome_fmpag FROM fm_pag WHERE deletado = 'n'");
            while ($forma_pagamento = mysqli_fetch_array($retorno_pag, MYSQLI_ASSOC)) {
                echo "<option value='{$forma_pagamento['nome_fmpag']}'>{$forma_pagamento['nome_fmpag']}</option>";
            }

            echo "</select>
                  </form>";

            echo "<div class='endereco'>
                    <form id='endereco-form'>
                        <input type='hidden' id='endereco-preenchido' value='0'>
                        <label for='nome_cliente'>Nome:</label>
                        <input type='text' id='nome_cliente' name='nome_cliente' required>
                        <label for='cep'>CEP:</label>
                        <input type='text' id='cep' name='cep' maxlength='9' onblur='buscarCep()'>
                        <label for='rua'>Rua:</label>
                        <input type='text' id='rua' name='rua'>
                        <label for='bairro'>Bairro:</label>
                        <input type='text' id='bairro' name='bairro'>
                        <label for='cidade'>Cidade:</label>
                        <input type='text' id='cidade' name='cidade'>
                        <label for='estado'>Estado:</label>
                        <input type='text' id='estado' name='estado'>
                        <label for='numero'>Nº:</label>
                        <input type='text' id='numero' name='numero'>
                    </form>
                </div>";

            echo "<a href='#' onclick='showEndereco()' class='botao'>Inserir informações</a>";
            echo "<a href='#' onclick='enviarWhatsApp()' class='botao'>Enviar pelo WhatsApp</a>";
            echo "<a href='catalogo.php' class='botao'>Catálogo</a>";
            echo "<form action='limpar_carrinho.php' method='post' style='display:inline;'>
                    <button type='submit' name='limpar' class='botao'>Limpar Carrinho</button>
                  </form>";

            echo "<br><br><b>Clique em Enviar pelo WhatsApp para entrar em contato direto com a loja. Se a mensagem não carregar, clique em Iniciar Conversa. O CEP preencherá o endereço automaticamente e o pedido será enviado por e-mail para a loja</b>";
        } else {
            echo "<div class='mensagem'>Seu carrinho está vazio.</div>";
            echo "<a href='catalogo.php' class='botao'>Catálogo</a>";
        }
        ?>

    </div>
    <script>
        function showEndereco() {
            var enderecoDiv = document.querySelector('.endereco');
            enderecoDiv.style.display = enderecoDiv.style.display === 'block' ? 'none' : 'block';
        }

        function buscarCep() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (cep !== "") {
                var validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    var script = document.createElement('script');
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=callbackEndereco';
                    document.body.appendChild(script);
                } else {
                    limparFormularioCep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limparFormularioCep();
            }
        }

        function callbackEndereco(conteudo) {
            if (!("erro" in conteudo)) {
                document.getElementById('rua').value = conteudo.logradouro;
                document.getElementById('bairro').value = conteudo.bairro;
                document.getElementById('cidade').value = conteudo.localidade;
                document.getElementById('estado').value = conteudo.uf;
                document.getElementById('endereco-preenchido').value = '1';
            } else {
                limparFormularioCep();
                alert("CEP não encontrado.");
            }
        }

        function limparFormularioCep() {
            document.getElementById('rua').value = "";
            document.getElementById('bairro').value = "";
            document.getElementById('cidade').value = "";
            document.getElementById('estado').value = "";
            document.getElementById('endereco-preenchido').value = '0';
        }

        function enviarWhatsApp() {
            var nomeCliente = document.getElementById('nome_cliente').value;
            var enderecoPreenchido = document.getElementById('endereco-preenchido').value;
            var endereco = '';

            if (enderecoPreenchido === '1') {
                var rua = document.getElementById('rua').value;
                var bairro = document.getElementById('bairro').value;
                var cidade = document.getElementById('cidade').value;
                var estado = document.getElementById('estado').value;
                var numero = document.getElementById('numero').value;
                endereco = `Endereço de Entrega:\nRua: ${rua}\nBairro: ${bairro}\nCidade: ${cidade}\nEstado: ${estado}\nNº: ${numero}`;
            } else {
                endereco = 'RETIRADA NA LOJA';
            }

            var vtotal = document.getElementById('total').value;
            var formaPagamento = document.getElementById('forma_pagamento').value;
            var produtosMensagem = `Olá, meu nome é ${nomeCliente} e gostaria de solicitar os seguintes produtos:\n\n<?php echo json_encode($produtos_mensagem); ?>\n\nForma de Pagamento: ${formaPagamento}\n\n${endereco}\n\nValor Total: ${vtotal}`;
            var telefone = "<?php echo $telefone_formatado; ?>";
            var whatsappUrl = `https://web.whatsapp.com/send?phone=55${telefone}&text=${encodeURIComponent(produtosMensagem)}`;

            // Enviar a mensagem via WhatsApp
            window.open(whatsappUrl, '_blank');

            // Enviar a mensagem via e-mail
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "enviar_email.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText); // Mostra a resposta do servidor
                }
            };
            xhr.send(`produtosMensagem=${encodeURIComponent(produtosMensagem)}&formaPagamento=${encodeURIComponent(formaPagamento)}&endereco=${encodeURIComponent(endereco)}&total=${encodeURIComponent(vtotal)}&nomeCliente=${encodeURIComponent(nomeCliente)}`);
        }
    </script>

</body>

</html>