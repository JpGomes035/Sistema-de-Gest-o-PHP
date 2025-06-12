<?php
include_once '../iniciar_sessao.php';
include_once('../head.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido de Compra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="pedido.css">
    <link rel="shortcut icon" href="monitor.png" type="image/x-icon">
</head>

<body>
    <div style="margin-top: 50px;"> <!-- Adicione um espaço no topo para não cobrir o menu -->
        <h2>Pedido de Compra</h2>
        <p><i class="fa fa-exclamation" aria-hidden="true"></i> O estoque dos produtos será somado caso a opção <b style="color: blue">SOMAR ESTOQUE</b> seja marcada </p>
        <p><i class="fa fa-exclamation" aria-hidden="true"></i> O Preço mostrados nos itens é <b style="color: blue">PREÇO DE CUSTO</b></p>
        <form action="processa_pedido_compra.php" method="post">
            <label for="fornecedor">Fornecedor:</label>
            <br>
            <br>
            <select class="form-control" id="nome_fornecedor" name="nome_fornecedor" required>
                <?php
                //puxar todos os forn cadastrados
                $sqlFornecedor = "SELECT * FROM fornecedor ORDER BY nomeForn ASC";
                $retornoFornecedor = mysqli_query($conexao, $sqlFornecedor);
                while ($array = mysqli_fetch_array($retornoFornecedor, MYSQLI_ASSOC)) {
                    $idFornecedor = $array["IdFornecedor"];
                    $nomeFornecedor = $array["nomeForn"];
                ?>
                    <option>
                        <?= $nomeFornecedor ?>
                    </option>
                <?php } ?>
            </select>
            <br>
            <br>
            <div class="form-group">
                <label for="responsavel_pedido">Usuário responsavel pelo Pedido:(não alterável depois)</label>
                <select class="form-control" id="responsavel_pedido" name="responsavel_pedido">
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
                <br>
                <br>
                <div id="produtos" class="form-control">
                    <label for="produto">Produto:</label>
                    <br>
                    <select name="produtos[]" required>
                        <option value="">Selecione um produto</option>
                        <?php
                        // Conexão com o banco de dados
                        include_once '../conexao.php';

                        // Consulta SQL para selecionar todos os produtos da tabela "estoque"
                        $sql = "SELECT idProduto, Nome, preco_custo, precovenda, Quantidade 
                        FROM estoque 
                        WHERE deletado = 'N' 
                        ORDER BY Nome ASC";;
                        $resultado = mysqli_query($conexao, $sql);

                        // Loop através dos resultados da consulta
                        while ($linha = mysqli_fetch_assoc($resultado)) {
                            $idProduto = $linha['idProduto'];
                            $nomeProduto = $linha['Nome'];
                            $valor_unitario_prod = $linha['preco_custo'];
                            $quantidade_estoque = $linha['Quantidade'];

                            echo "<option value='$idProduto'>Nome: $nomeProduto -- Preço de custo: $valor_unitario_prod -- Estoque: $quantidade_estoque </option> "; // Alteração aqui

                        }
                        ?>
                    </select>
                    <br><br>

                    <label for="quantidade">Quantidade:</label>
                    <input type="number" name="quantidades[]" min="1" required><br><br>

                    <label for="valor_unitario">Valor Unitário:</label>
                    <input type="number" name="valor_unitario[]" min="0.01" step="0.01" required><br>

                </div>
                <button type="button" onclick="adicionarProduto()">Adicionar Produto</button><br><br>
                <label for="somar_estoque">Somar Estoque? </label>
                <input type="checkbox" id="somar_estoque" name="somar_estoque" value="1"> <- SOMAR
                    <br>
                    <br>
                    <label for="adicionar_valor">Subtrair valor ao banco?</label>
                    <input type="checkbox" id="adicionar_valor" name="adicionar_valor" value="1"> <- Subtrair valor
                    <br>
                    <br>
                    <label for="data">Data de Emissão:</label>
                    <input type="date" id="data" name="data" class="form-control" placeholder="Insira a data de Emissão"
                        required>
                    <br>
                    <br>

                    <label for="valor_total">Valor Total:</label>
                    <input type="number" id="valor_total" class="form-control" name="valor_total" step="0.01"
                        placeholder="Valor total com descontos ou acrescimos" required>
                    <br><br>

                    <label for="fm_pag">Forma de Pagamento: </label>
                    <select class="form-control" id="fm_pag" name="fm_pag">
                        <?php

                        $sqlnome = "SELECT * FROM fm_pag WHERE deletado = 'N' ORDER BY nome_fmpag";
                        $retornonome = mysqli_query($conexao, $sqlnome);
                        while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                            $id_fmpag = $array["id_fmpag "];
                            $nome_fmpag = $array["nome_fmpag"];
                        ?>
                            <option>
                                <?= $nome_fmpag ?>
                            </option>
                        <?php } ?>
                    </select>
                    <label for="banco_receb">Qual o banco responsavel?</label>
                    <select class="form-control" id="banco_receb" name="banco_receb">
                        <?php
                        $sqlnome = "SELECT * FROM banco ORDER BY nomeBanco ASC";
                        $retornonome = mysqli_query($conexao, $sqlnome);
                        while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                            $idBanco = $array["idBanco"];
                            $nomeBanco = $array["nomeBanco"];
                        ?>
                            <option>
                                <?= $nomeBanco ?>
                            </option>
                        <?php } ?>
                    </select>
                    <label for="observacoes">Observações:</label><br>
                    <textarea id="observacoes" name="observacoes" rows="4" cols="50"></textarea><br><br>

                    <input type="submit" class="btn-enviar btn btn-success btn-sm btn-block" value="Enviar Pedido">
                    <a href="../lista_pedido_compras.php" class="listagem">Listagem</a>
        </form>
    </div>
    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.display === "none") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }
    </script>
    <script>
        function adicionarProduto() {
            // Clona o conjunto de campos de seleção de produtos
            var container = document.getElementById("produtos");
            var novoProduto = container.cloneNode(true);

            // Limpa o valor selecionado do novo conjunto de campos de seleção
            var selects = novoProduto.querySelectorAll("select[name='produtos[]']");
            selects.forEach(function(select) {
                select.selectedIndex = 0;
            });

            // Limpa os valores de quantidade e valor unitário apenas do novo conjunto de campos
            var novoQuantidadeInput = novoProduto.querySelector("input[name='quantidades[]']");
            novoQuantidadeInput.value = "";

            var novoValorUnitarioInput = novoProduto.querySelector("input[name='valor_unitario[]']");
            novoValorUnitarioInput.value = "";

            // Insere o novo conjunto de campos de seleção antes do botão "Adicionar Produto"
            container.parentNode.insertBefore(novoProduto, container.nextSibling);
        }
    </script>
    <script>
        // Função para calcular o valor total
        function calcularValorTotal() {
            // Obtém todos os campos de valor unitário e quantidade
            var valorUnitarioInputs = document.querySelectorAll("input[name='valor_unitario[]']");
            var quantidadeInputs = document.querySelectorAll("input[name='quantidades[]']");

            // Inicializa a soma total
            var total = 0;

            // Loop através dos campos de valor unitário e quantidade e calcula o subtotal para cada produto
            for (var i = 0; i < valorUnitarioInputs.length; i++) {
                var valorUnitario = parseFloat(valorUnitarioInputs[i].value);
                var quantidade = parseInt(quantidadeInputs[i].value);
                var subtotal = valorUnitario * quantidade;
                total += subtotal;
            }

            // Atualiza o campo "valor_total" com a soma calculada
            document.getElementById("valor_total").value = total.toFixed(2);
        }
    </script>

    <!-- Adicione um evento onchange para calcular o valor total sempre que houver uma alteração nos campos de valor unitário ou quantidade -->
    <script>
        document.addEventListener("change", function(event) {
            if (event.target && (event.target.name === "valor_unitario[]" || event.target.name === "quantidades[]")) {
                calcularValorTotal();
            }
        });
    </script>
    <script>
        let inatividadeTimeout;

        function iniciarTemporizadorInatividade() {
            inatividadeTimeout = setTimeout(realizarLogoff, 600000); // 10 minutos (600000 milissegundos)
        }

        function resetarTemporizadorInatividade() {
            clearTimeout(inatividadeTimeout);
            iniciarTemporizadorInatividade();
        }

        function realizarLogoff() {
            // Coloque aqui o código para fazer o logoff, por exemplo, redirecionar para a página de logoff
            window.location.href = "../sair.php";
        }

        document.addEventListener('mousemove', resetarTemporizadorInatividade);
        document.addEventListener('keydown', resetarTemporizadorInatividade);

        // Inicia o temporizador quando a página é carregada
        iniciarTemporizadorInatividade();
    </script>

</body>

</html>