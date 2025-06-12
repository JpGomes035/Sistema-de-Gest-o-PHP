<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="painel.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
<head>
  <title>Painel</title>
</head>
<body>
  <div class="container">
    <div class="panel">
      <p style="color: white; font-size: 16px; text-align: center;">Painel do Sistema.</p>
      <div class="chart">
        <div class="chart-header">
        </div>
        <div class="chart-content">
          <div class="chart-labels">
            <span class="fa fa-money"> Rendas:</span>
          </div>
          <?php
          include_once 'conexao.php';
          $sql2 = "SELECT SUM(quantos) AS total FROM entrada where deletado = 'N';";
          $retorno2 = mysqli_query($conexao, $sql2);

          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $total = $resultado['total'];

            // Exibe o resultado na tela
            echo "<p class='chart-label'>Entrada: R$" . number_format($total, 2, ',', '') . "</p>";
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }
          include_once 'conexao.php';
          $sql2 = "SELECT SUM(valor_parcela) AS v_total FROM contas_receber where status ='S';";
          $retorno2 = mysqli_query($conexao, $sql2);

          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $v_total = $resultado['v_total'];

            // Exibe o resultado na tela
            echo "<p class='chart-label'>Contas Recebidas: R$" . number_format($v_total, 2, ',', '') . "</p>";
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }
          include_once 'conexao.php';
          $sql2 = "SELECT SUM(valorOs) AS v_totalOs FROM ordem_servico WHERE status = 'F';";
          $retorno2 = mysqli_query($conexao, $sql2);
          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $v_totalOs = $resultado['v_totalOs'];
            // Exibe o resultado na tela
            echo "<p class='chart-label'>OS(Finalizadas): R$" . number_format($v_totalOs, 2, ',', '') . "</p>";
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }
          $sql2 = "SELECT SUM(valor_total) AS v_total_pedidos FROM pedidos where pago ='S' and deletado = 'N';";
          $retorno2 = mysqli_query($conexao, $sql2);

          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $v_total_pedidos = $resultado['v_total_pedidos'];

            // Exibe o resultado na tela
            echo "<p class='chart-label'>Pedidos Recebidos: R$" . number_format($v_total_pedidos, 2, ',', '') . "</p>";
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }

          $total_tudo = $total + $v_total + $v_totalOs + $v_total_pedidos;
          ?>

          <div class="chart-bar-recebidos" style="width: 79%;">
            <?php echo "R$" . number_format($total_tudo, 2, ',', ''); ?>
          </div>
        </div>
      </div>
      <div class="chart">
        <div class="chart-content">
          <div class="chart-labels">
            <span class="fa fa-money"> Despesas:</span>
          </div>
          <?php
          include_once 'conexao.php';
          $sql3 = "SELECT SUM(quantos) AS total FROM saida;";
          $retorno3 = mysqli_query($conexao, $sql3);

          if ($retorno3) {
            // Extrai o resultado da consulta
            $resultado2 = mysqli_fetch_assoc($retorno3);
            $total2 = $resultado2['total'];
            echo "<p class='chart-label'>Saída é: R$" . number_format($total2, 2, ',', '') . "</p>";

            include_once 'conexao.php';
            $sql2 = "SELECT SUM(valor_parcela) AS v_total_despesas FROM contas_pagar WHERE status = 's';";
            $retorno2 = mysqli_query($conexao, $sql2);

            if ($retorno2) {
              // Extrai o resultado da consulta
              $resultado = mysqli_fetch_assoc($retorno2);
              $v_total_despesas = $resultado['v_total_despesas'];

              // Exibe o resultado na tela
              echo "<p class='chart-label'>Contas pagas: R$" . number_format($v_total_despesas, 2, ',', '') . "</p>";
            } else {
              // Se houver algum erro na consulta
              echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
            }

            $sql2 = "SELECT SUM(valor_total) AS v_total_ped_compras FROM pedido_compra where pago ='S' and deletado = 'N';";
            $retorno2 = mysqli_query($conexao, $sql2);

            if ($retorno2) {
              // Extrai o resultado da consulta
              $resultado = mysqli_fetch_assoc($retorno2);
              $v_total_ped_compras = $resultado['v_total_ped_compras'];

              // Exibe o resultado na tela
              echo "<p class='chart-label'>Pedidos Pagos: R$" . number_format($v_total_ped_compras, 2, ',', '') . "</p>";
            } else {
              // Se houver algum erro na consulta
              echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
            }

            $total_despesas = $total2 + $v_total_despesas + $v_total_ped_compras;

            // Calcula a diferença entre a renda e despesa
            $diferenca = $total_tudo - $total_despesas;

            // Formata a cor da diferença com base na condição
            $corDiferenca = ($total_tudo > $total_despesas) ? 'green' : 'red';

            // Exibe o resultado na tela com a cor formatada
            echo sprintf('<p style="color: %s;">A diferença entre renda e despesas é: R$%s</p>', $corDiferenca, $diferenca);
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }
          ?>
          <div class="chart-bar" style="width: 50%;">
            <?php echo "R$" . number_format($total_despesas, 2, ',', ''); ?>
          </div>
        </div>
      </div>
      <h6>Clique aqui para realizar o Backup: <a href="backup\backup.php"><i class="fa fa-database"
            aria-hidden="true"></i> Realizar backup.</a></h6>
      <h6>Listagem de Backup: <a href="backup/lista_backup.php"><i class="fa fa-database" aria-hidden="true"></i>
          Backups.</a></h6>
      <h6>Guardar XML: <a href="xml/index.php"><i class="fa fa-code" aria-hidden="true"></i> XML.</a></h6>
      <h6>Voltar: <a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Menu.</a></h6>
      

    </div>
    <?php include_once('footer.php') ?>
  </div>
</body>

</html>