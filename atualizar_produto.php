<?php
include_once 'conexao.php';
include_once 'iniciar_sessao.php';

$id = $_POST['idProduto'];
$categoria = $_POST['categoria'];
$fornecedor = $_POST['Fornecedor'];
$nomeProduto = $_POST['nomeProduto'];
$numero = $_POST['Numero'];
$quantidadeProduto = $_POST['quantidadeProduto'];
$precovenda = $_POST['precovenda'];
$catalogo = $_POST['catalogo']; 
$promocao = $_POST['promocao']; 

// Verifica se foi feito upload de uma nova imagem
if (!empty($_FILES['img_prod']['name'])) {
    $nomeOriginal = $_FILES['img_prod']['name'];
    $caminhoTmp = $_FILES['img_prod']['tmp_name'];

    // Gera um identificador único para o nome do arquivo
    $unique_id = uniqid();
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $nomeArquivo = $unique_id . '.' . $extensao;
    $caminhoSalvar = 'upload-prod/' . $nomeArquivo;

    // Move o arquivo para a pasta de uploads
    if (move_uploaded_file($caminhoTmp, $caminhoSalvar)) {
        // Atualiza o campo img_prod no banco de dados
        $sql = "UPDATE estoque SET Nome = '$nomeProduto', Categoria = '$categoria', Quantidade = $quantidadeProduto, Numero = '$numero', Fornecedor = '$fornecedor', precovenda = '$precovenda', img_prod = '$caminhoSalvar', catalogo = '$catalogo', promocao = '$promocao' WHERE IdProduto = $id";
    } else {
        echo "Desculpe, houve um erro ao fazer o upload da sua imagem.";
        exit;
    }
} else {
    // Se não houver upload de nova imagem, atualiza apenas os outros campos
    $sql = "UPDATE estoque SET Nome = '$nomeProduto', Categoria = '$categoria', Quantidade = $quantidadeProduto, Numero = '$numero', Fornecedor = '$fornecedor', precovenda = '$precovenda', catalogo = '$catalogo', promocao = '$promocao' WHERE IdProduto = $id";
}

$update = mysqli_query($conexao, $sql);

if ($update) {
    header("Location: listar_produtos.php?atualizado=" . $id);
} else {
    echo "Erro ao atualizar produto: " . mysqli_error($conexao);
}
?>
