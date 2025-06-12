<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Relatórios em Excel</title>
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
        .dark-mode p{
            color: whitesmoke;
        }
    </style>
</head>

<body>
    <?php include_once('menu.php'); ?>
    <br>
    <br>
    <br>
    <h3><b>Exportar para o Excel:</b></h3>
    <br>
    <br>
    <p>Exporte todos os relatórios para uma planilha Excel com apenas um clique! Não perca tempo compilando dados manualmente. Experimente agora e simplifique seu trabalho!</p>
    <h5><b> Relatórios para Excel:</b></h5>

    <h6>Exportar Entradas para excel: <a href="excel/excel_entrada.php"> Entrada.</a></h6>
    <h6>Exportar Saídas para excel: <a href="excel/excel_saida.php"> Saída.</a></h6>
    <h5><b>-------Relatório Contas-------</b></h5>
    <h6>Exportar Contas Pagas/Pagar: <a href="excel/excel_contas_pag.php"> Contas Pagas/Pagar.</a></h6>
    <h6>Exportar Contas Recebidas/Receber: <a href="excel/excel_contas_rec.php"> Contas Recebidas/Receber.</a></h6>

    <h5><b>-------Relatório Boleto-------</b></h5>
    <h6>Exportar Boletos Pagos/Pendentes/Vencidos/Recebidos: <a href="excel/excel_boletos.php"> Boletos.</a></h6>

    <h5><b>-------Relatório Pedidos-------</b></h5>
    <h6>Exportar Pedidos Vendas: <a href="excel/excel_ped_venda.php"> Pedidos de Venda.</a></h6>
    <h6>Exportar Pedidos Compra: <a href="excel/excel_ped_compra.php"> Pedidos de Compra.</a></h6>


    <h5><b><i class="fa fa-archive" aria-hidden="true"></i> Gerais:</b></h5>
    <h6>Exportar Transportes: <a href="excel/excel_transporte.php"> Transportes.</a></h6>
    <h6>Exportar Info Banco: <a href="excel/excel_banco.php"> Banco.</a></h6>
    <h5><b>------------------------------</b></h5>
    
    
    <h5><b><i class="fa fa-bars" aria-hidden="true"></i> Estoque/Produtos:</b></h5>
    <h6>Exportar Produtos: <a href="excel/excel_prod.php"> Produtos.</a></h6>

    <br>
    <br>
    <a href="relatorios.php">Voltar</a>

    </div>
</body>

</html>