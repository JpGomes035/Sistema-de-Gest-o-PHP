<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Catálogo de Produtos</title>
</head>

<body>

    <body>
        <div class="header">
            <?php include_once '../conexao.php'; ?>
            <?php
            // Conexão e sessão
            include_once '../iniciar_sessao.php';
            include_once '../conexao.php';

            // Consulta dados da empresa
            $sqlEmpresa = "SELECT nome, CNPJ, email, telefone, rua, cep, cidade, bairro, imagemempresa FROM informacoes WHERE id_info = '13'";
            $resultEmpresa = mysqli_query($conexao, $sqlEmpresa);

            // Verifica se encontrou a empresa
            if (mysqli_num_rows($resultEmpresa) > 0) {
                $empresa = mysqli_fetch_assoc($resultEmpresa);

                // Define a logo atual da empresa (se não houver, usa uma padrão)
                $logo_atual = !empty($empresa['imagemempresa']) ? $empresa['imagemempresa'] : 'upload-logo/default.jpg';

                // Exibe o conteúdo
                echo '<div class="header-content">';

                // LOGO
                echo '<div class="logo-container">';
                echo '<img src="../' . $logo_atual . '" alt="Logo da Empresa" class="logo" ondblclick="ampliarImagem(this)">';
                echo '</div>';

                // DADOS DA EMPRESA
                echo '<div class="empresa-header">';
                echo '<p><strong>Empresa:</strong> ' . $empresa['nome'] . '</p>';
                echo '<p><strong>CNPJ:</strong> ' . $empresa['CNPJ'] . '</p>';
                echo '<p><strong>Email:</strong> ' . $empresa['email'] . '</p>';
                echo '<p><strong>Telefone:</strong> ' . $empresa['telefone'] . '</p>';
                echo '<p><strong>Endereço:</strong> ' . $empresa['rua'] . ', ' . $empresa['bairro'] . ', ' . $empresa['cidade'] . ' - ' . $empresa['cep'] . '</p>';
                echo '</div>';

                echo '</div>';
            } else {
                echo "<p>Informações da empresa não encontradas.</p>";
            }
            ?>

        </div>
        <div id="alert-modal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="fecharAlerta()">&times;</span>
                <p id="alert-message">Quantidade maior do que temos em estoque.</p>
            </div>
        </div>
        <div class="filtros">
            <form id="filterForm" method="get">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria">
                    <option value="">Todas</option>
                    <?php
                    $sql = "SELECT DISTINCT Categoria FROM estoque WHERE deletado = 'N'";
                    $result = mysqli_query($conexao, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['Categoria']}'" . (isset($_GET['categoria']) && $_GET['categoria'] == $row['Categoria'] ? ' selected' : '') . ">{$row['Categoria']}</option>";
                    }
                    ?>
                </select>

                <label for="preco">Preço:</label>
                <select name="preco" id="preco">
                    <option value="">Todos</option>
                    <option value="low" <?php if (isset($_GET['preco']) && $_GET['preco'] == 'low') echo 'selected'; ?>>Menor que R$50</option>
                    <option value="medium" <?php if (isset($_GET['preco']) && $_GET['preco'] == 'medium') echo 'selected'; ?>>R$50 - R$100</option>
                    <option value="high" <?php if (isset($_GET['preco']) && $_GET['preco'] == 'high') echo 'selected'; ?>>Maior que R$100</option>
                </select>

                <label for="busca">Buscar:</label>
                <input type="text" name="busca" id="busca" value="<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>" placeholder="Nome ou descrição">

                <button type="submit">Filtrar</button>
            </form>
        </div>

        <div class="catalogo">
            <?php
            $whereClauses = ["deletado = 'N'", "catalogo = 's'"];
            if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
                $categoria = $_GET['categoria'];
                $whereClauses[] = "Categoria = '$categoria'";
            }
            if (isset($_GET['preco']) && $_GET['preco'] != '') {
                $preco = $_GET['preco'];
                if ($preco == 'low') {
                    $whereClauses[] = "precovenda < 50";
                } elseif ($preco == 'medium') {
                    $whereClauses[] = "precovenda BETWEEN 50 AND 100";
                } elseif ($preco == 'high') {
                    $whereClauses[] = "precovenda > 100";
                }
            }
            if (isset($_GET['busca']) && $_GET['busca'] != '') {
                $busca = $_GET['busca'];
                $whereClauses[] = "(Nome LIKE '%$busca%' OR descProd LIKE '%$busca%')";
            }

            $whereSql = implode(' AND ', $whereClauses);

            $perPage = 10; // Número de produtos por página
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $perPage;

            // Primeiro, obtenha o número total de produtos
            $sqlTotal = "SELECT COUNT(*) as total FROM estoque WHERE $whereSql";
            $resultTotal = mysqli_query($conexao, $sqlTotal);
            $rowTotal = mysqli_fetch_assoc($resultTotal);
            $totalProdutos = $rowTotal['total'];

            $totalPages = ceil($totalProdutos / $perPage);

            $sql = "SELECT IdProduto, Categoria, descProd, Fornecedor, Nome, Numero, Quantidade, precovenda, precoPromocional, promocao, img_prod FROM estoque WHERE $whereSql LIMIT $offset, $perPage";
            $result = mysqli_query($conexao, $sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imgPath = "../" . $row['img_prod'];

                    if (!file_exists($imgPath) || empty($row['img_prod'])) {
                        $imgPath = "../upload-prod/default.jpg";
                    }

                    $precoVenda = number_format($row['precovenda'], 2, ',', '.');
                    $precoPromocional = isset($row['precoPromocional']) ? number_format(floatval($row['precoPromocional']), 2, ',', '.') : null;
                    $emPromocao = $row['promocao'] === 's';

                    echo "<div class='produto" . ($emPromocao ? " promocao" : "") . "'>
                    " . ($emPromocao ? "<div class='faixa-promocao'>Promoção</div>" : "") . "
                    <img src='{$imgPath}' alt='{$row['Nome']}'>
                    <h2>{$row['Nome']}</h2>
                    
                    <p>Categoria: {$row['Categoria']}</p>
                    <p>Fornecedor: {$row['Fornecedor']}</p>
                    <p>Estoque: {$row['Quantidade']}</p>
                    <p>{$row['descProd']}</p>" .
                        ($emPromocao ? "<p class='preco preco-riscado'>R$ {$precoVenda}</p><p class='preco-promocional'>R$ {$precoPromocional}</p>" : "<p class='preco'>R$ {$precoVenda}</p>") . "
                    <form action='carrinho.php' method='post'>
                        <input type='hidden' name='idProduto' value='{$row['IdProduto']}'>
                        <input type='hidden' name='nomeProduto' value='{$row['Nome']}'>
                        <input type='hidden' name='precoProduto' value='{$row['precovenda']}'>
                    <input type='number' name='quantidade' min='1' max='" . $row["Quantidade"] . "' value='1' class='input-quantidade' onchange='verificarQuantidade(this, " . $row["Quantidade"] . ")'>
                        <script>
                    function verificarQuantidade(input, maxQuantidade) {
                        if (parseInt(input.value) > maxQuantidade) {
                            mostrarAlerta('Quantidade maior do que temos em estoque.');
                            input.value = maxQuantidade;
                        }
                    }

                    function mostrarAlerta(mensagem) {
                        document.getElementById('alert-message').innerText = mensagem;
                        document.getElementById('alert-modal').style.display = 'block';
                    }

                    function fecharAlerta() {
                        document.getElementById('alert-modal').style.display = 'none';
                    }
                    </script>         
<br>
<br>
                <button type='submit' name='adicionar' class='botao-car'>Adicionar <i class='fa fa-shopping-cart' aria-hidden='true'></i></button>
                </form>
                </div>";
                }
            } else {
                echo "<p>Nenhum produto encontrado.</p>";
            }
            ?>
        </div>


        <div class="pagination">
            <?php
            // Limpar duplicação de parâmetros na URL
            $queryString = $_GET;
            unset($queryString['page']);

            for ($i = 1; $i <= $totalPages; $i++) {
                $queryString['page'] = $i;
                $newQueryString = http_build_query($queryString);
                echo "<a href='?{$newQueryString}'>$i</a>";
            }
            ?>
        </div>
        <?php include_once '../conexao.php'; ?>
        <?php
        // Consulta SQL para buscar informações da empresa
        $sqlEmpresa = "SELECT nome, CNPJ, email, telefone, rua, cep, cidade, bairro FROM informacoes WHERE id_info = '13'";
        $resultEmpresa = mysqli_query($conexao, $sqlEmpresa);
        if (mysqli_num_rows($resultEmpresa) > 0) {
            $empresa = mysqli_fetch_assoc($resultEmpresa);
            echo '<footer class="empresa-info">';
            echo '<p>' . $empresa['nome'] . ' /';
            echo ' fale com a gente - ' . $empresa['email'] . '</p>';
            echo '<p><strong><a href="../index.html">VOLTAR</a></strong></p>';
            echo '</footer>';
        } else {
            echo "<p>Informações da empresa não encontradas.</p>";
        }
        ?>

        <script>
            window.addEventListener('scroll', function() {
                const footer = document.querySelector('footer.empresa-info');
                if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 50)) {
                    footer.classList.add('show-footer');
                } else {
                    footer.classList.remove('show-footer');
                }
            });
        </script>
        <div class="botao-carrinho-container">
            <a href="visualizar_carrinho.php" class="botao-carrinho-visualizar">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </body>

</html>