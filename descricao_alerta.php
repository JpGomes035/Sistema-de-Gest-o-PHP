<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
$id_Alertas = $_GET['id_Alertas'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notificações</title>
    <style>
        .container {
            padding-top: 20px;
        }

        .form-control {
            width: 300px;
            display: inline-block;
        }

        .btn-primary {
            margin-left: 10px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination-link {
            padding: 5px 10px;
            margin: 0 5px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 3px;
        }

        .pagination-link:hover,
        .pagination-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-editar {
            margin-right: 5px;
        }

        #alerta {
            margin-top: 20px;
        }

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
            justify-content: center;
            font-weight: bold;
        }

        th,
        tr,
        td {
            text-align: center;
            font-weight: bold;
            border-width: 2px;
            border-style: solid;
            border-color: black;
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

        h6 {
            text-align: center;
            color: black;
            font-weight: bold;
        }

        a {
            Color: grey;
            font-weight: bold;
        }

        a:hover {
            Color: black;
            font-weight: bold;
        }

        h3 {
            text-align: left;
            color: black;
            font-size: 25px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include_once('menu.php'); ?>
    <div class="container">
        <h3 style="margin-bottom:20px">Descrição do alerta #
            <?php echo $id_Alertas ?>
        </h3>
        <?php
        include_once 'conexao_alert.php';

        // Configuração da paginação
        $registrosPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $offset = ($paginaAtual - 1) * $registrosPorPagina;

        // Filtro de pesquisa
        $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

        // Consulta SQL com filtro de pesquisa
        $sql = "SELECT * FROM alertas WHERE id_Alertas = $id_Alertas";
        $retorno = mysqli_query($conexao, $sql);

        $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT id_Alertas FROM `alertas` WHERE descricao_Alerta LIKE '%$pesquisar%'"));
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Descrição estendida</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //pegar as info da SQL
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $id_Alertas = $array['id_Alertas'];
                    $descricao_Alerta = $array['descricao_Alerta'];
                    $descricao_extendida = $array['descricao_extendida'];
                    ?>
                    <tr>
                        <td>
                            <?= $id_Alertas ?>
                        </td>
                        <td>
                            <?= $descricao_Alerta ?>
                        </td>
                        <td>
                            <?= $descricao_extendida ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h6>Esses alertas/notificações são direto de seus respectivos setores.</h6>
        <a href="listar_alertas.php">Voltar</a>
    </div>

    <?php
    if (isset($_GET['atualizado'])) {
        echo '<div id="alerta" class="alert alert-success" role="alert">
                Categoria <b>' . $_GET['atualizado'] . '</b> atualizada com sucesso!.
                </div>';
    }
    if (isset($_GET['excluido'])) {
        echo '<div id="alerta" class="alert alert-danger" role="alert">
                Categoria <b>' . $_GET['excluido'] . '</b> excluída com sucesso!.
                </div>';
    }

    // Exibir a paginação somente se houver mais de uma página
    if ($totalPaginas > 1) {
        ?>
        <div class="pagination">
            <?php if ($paginaAtual > 1) { ?>
                <a class="pagination-link" href="?pagina=1&pesquisar=<?= $pesquisar ?>">Primeira</a>
                <a class="pagination-link" href="?pagina=<?= ($paginaAtual - 1) ?>&pesquisar=<?= $pesquisar ?>">Anterior</a>
            <?php } ?>
            <?php for ($i = max(1, $paginaAtual - 2); $i <= min($paginaAtual + 2, $totalPaginas); $i++) { ?>
                <a class="pagination-link <?= $paginaAtual == $i ? 'active' : '' ?>"
                    href="?pagina=<?= $i ?>&pesquisar=<?= $pesquisar ?>">
                    <?= $i ?>
                </a>
            <?php } ?>
            <?php if ($paginaAtual < $totalPaginas) { ?>
                <a class="pagination-link" href="?pagina=<?= ($paginaAtual + 1) ?>&pesquisar=<?= $pesquisar ?>">Próxima</a>
                <a class="pagination-link" href="?pagina=<?= $totalPaginas ?>&pesquisar=<?= $pesquisar ?>">Última</a>
            <?php } ?>
        </div>
    <?php } ?>
    </div>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function () {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>
    <?php include_once 'footer.php' ?>
</body>

</html>