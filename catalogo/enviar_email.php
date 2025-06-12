<?php
include_once '../conexao.php';

// Obter informações da empresa
$sql = "SELECT id_info, nome, cnpj, email, telefone, rua, cep, cidade FROM `informacoes`";
$retorno = mysqli_query($conexao, $sql);

while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
    $nomeEmpresa = $array['nome'];
    $emailEmpresa = $array['email'];
    // outros dados...
}

$produtosMensagem = $_POST['produtosMensagem'];
$formaPagamento = $_POST['formaPagamento'];
$endereco = $_POST['endereco'];
$valorTotal = $_POST['total'];

// Configurar e enviar o e-mail
$to = $emailEmpresa;
$subject = "Novo Pedido";
$body = "Olá, " .$nomeEmpresa ." você recebeu um novo pedido via Catálogo:\n\n" . $produtosMensagem . "\n\nForma de Pagamento: " . $formaPagamento . "\n\n" . $endereco . "\n\nValor Total: " . $valorTotal;

// Definir o e-mail fixo de remetente
$headers = "From: no-reply@procontrol.com";

if (mail($to, $subject, $body, $headers)) {
    echo "E-mail enviado com sucesso.";
} else {
    echo "Erro ao enviar e-mail.";
}
?>
