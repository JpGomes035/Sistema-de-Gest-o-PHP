<?php
session_start();

// Verifica se o carrinho já foi iniciado
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Verifica se o botão 'adicionar' foi clicado
if (isset($_POST['adicionar'])) {
    $idProduto = $_POST['idProduto'];
    $nomeProduto = $_POST['nomeProduto'];
    $precoProduto = $_POST['precoProduto'];
    $quantidadeSolicitada = $_POST['quantidade'];

    // Conecta ao banco de dados
    include_once '../conexao.php';

    // Consulta para verificar o estoque disponível e se o produto está em promoção
    $sql = "SELECT quantidade, promocao, precoPromocional FROM estoque WHERE IdProduto = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idProduto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $quantidadeEstoque, $promocao, $precoPromocional);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verifica se a quantidade solicitada não ultrapassa o estoque disponível
    if ($quantidadeSolicitada <= $quantidadeEstoque) {
        // Se o produto estiver em promoção, usa o preço promocional
        if ($promocao == 's' && !empty($precoPromocional)) {
            $precoProduto = $precoPromocional;
        }

        // Adiciona o produto ao carrinho
        $_SESSION['carrinho'][] = array(
            'id' => $idProduto,
            'nome' => $nomeProduto,
            'preco' => $precoProduto,
            'quantidade' => $quantidadeSolicitada
        );

        // Redireciona para a página do catálogo com mensagem de sucesso
        header('Location: catalogo.php?msg=Produto adicionado ao carrinho');
    } else {
        // Redireciona para a página do catálogo com mensagem de erro
        header('Location: catalogo.php?msg=Quantidade solicitada excede o estoque disponível');
    }
}
?>
