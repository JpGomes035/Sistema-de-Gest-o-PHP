<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Relatórios</title>
    <style>
        /* Estilos CSS */
        a {
            color: black;
            text-align: left;
            text-align: center;
            transition: color 0.3s ease-in-out;
            font-weight: bold;
        }
        a:hover{
            color: red;
        }

        body {
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: black;
            font-family: Arial, sans-serif;
            text-align: center;
            font-weight: bold;
        }

        h6 {
            font-size: 20px;
            text-align: left;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include_once('menu.php'); ?>
    <br>
    <br>
    <br>
    <h3><b><i class="fa fa-bar-chart" aria-hidden="true"></i> Relatórios:</b></h3>
    <br>
    <h5><b><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar os Relatorios em Excel:</b></h5>
    <h6>Exportar dados para Excel: <a href="relatorio_excel.php"> Exportar Excel.</a></h6>
    <br>
    <h5><b><i class="fa fa-money" aria-hidden="true"></i> Financeiro:</b></h5>
    
    <h6>Verificar Relatório entrada: <a href="relatorio_entrada.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Entrada.</a></h6>
    <h6>Verificar Relatório Saída: <a href="relatorio_saida.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Saída.</a></h6>
    <h5><b>-------Relatório Contas-------</b></h5>
    <h6>Verificar Relatório Contas Pagas: <a href="relatorio_contas_pagas.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Contas Pagas.</a></h6>
    <h6>Verificar Relatório Contas Recebidas: <a href="relatorio_contas_recebidas.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Contas Recebidas.</a></h6>
    <h6>Verificar Relatório Contas a Pagar: <a href="relatorio_contas_pagar.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Contas a Pagar.</a></h6>
    <h6>Verificar Relatório Contas a Receber: <a href="relatorio_contas_areceber.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Contas a Receber.</a></h6>
    <h5><b>-------Relatório Boletos-------</b></h5>
    <h6>Verificar Relatório Boletos Pagos: <a href="relatorio_boletospago.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Boletos Pagos.</a></h6>
    <h6>Verificar Relatório Boletos Pendentes: <a href="relatorio_boletospendentes.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Boletos Pendentes.</a></h6>
    <h6>Verificar Relatório Boletos Vencidos: <a href="relatorio_boletosvencidos.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Boletos Vencidos.</a></h6>
    <h6>Verificar Relatório Boletos Recebidos: <a href="relatorio_boletosrecebidos.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Boletos Recebidos.</a></h6>
    <h5><b>-------Relatório Pedidos-------</b></h5>
    <h6>Verificar Relatório Pedido Venda: <a href="relatorio_pedido_venda.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Pedidos de Venda.</a></h6>
    <h6>Verificar Relatório Pedido Compra: <a href="relatorio_pedido_compra.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Pedidos de Compra.</a></h6>


    <h5><b><i class="fa fa-archive" aria-hidden="true"></i> Gerais:</b></h5>
    <h6>Verificar Relatório Transportes: <a href="relatorio_transporte.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Ver Transportes.</a></h6>
    <h6>Verificar Relatório Extrato Pedidos Recebidos e Pagos (Exportavel para Excel): <a href="relatorios_extrato.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Ver Extrato(pedidos compra/venda recebidos).</a></h6>
    <h6>Verificar Relatório Extrato Pedidos não pagos não recebidos (Exportavel para Excel): <a href="relatorio_extratonaorecebido.php?dataInicio=01/01/2024&dataFim=01/01/2024"> Ver Extrato(pedidos compra/venda não recebidos).</a></h6>
    <h5><b>------------------------------</b></h5>
    
    
    <h5><b><i class="fa fa-bars" aria-hidden="true"></i> Estoque/Produtos:</b></h5>
    <h6>Verificar Relatório Produtos: <a href="imprimir_produtos.php"> Produtos.</a></h6>
    <h6>Verificar Relatório Valor Estoque: <a href="relatorio_estoque.php"> Estoque.</a></h6>
    <h6>Verificar Relatório Produtos mais vendidos: <a href="relatorio_prod_vendidos.php"> Produtos mais vendidos.</a></h6>
    <h6>Sugestão de Compra: <a href="estoque_baixo.php">Verificar Sugestão.</a></h6>

<br>
    </div>
</body>

</html>