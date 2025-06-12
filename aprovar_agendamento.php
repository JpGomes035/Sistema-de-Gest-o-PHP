<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
include_once('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Aprovar agenda</title>
<style>
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

    h1 {
        font-size: 24px;
        font-weight: bold;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        font-weight: bold;
    }
    td, th{
        font-weight: bold;
    }
</style>

<body>
    <?php include_once 'menu.php'; ?>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:30px">Lista de agendamentos</h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Data</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Nível</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
include_once 'conexao.php';
$sql = "SELECT * FROM `agenda` WHERE nivelAprov = 'Inativo'";
$retorno = mysqli_query($conexao, $sql);

if (mysqli_num_rows($retorno) > 0) {
    while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
        $idAgenda = $array['idAgenda'];
        $titulo = $array['titulo'];
        $data = $array['data'];
        $descricao = $array['descricao'];
        $nivelAprov = $array['nivelAprov'];
        $telAgenda = $array['telAgenda'];
        switch ($nivelAprov) {
            case 1:
                $nivelAprov = "Ativo";
                break;
        }
        $idAgenda = $array['idAgenda'];
        
        ?>
        <tr>
            <td><?= $idAgenda ?></td>
            <td><?= $titulo ?></td>
            <?php
            $data_original = $data;
            $timestamp = strtotime($data_original);
            $data_formatada = date("d/m/y", $timestamp);
            ?>
            <td><?= $data_formatada ?></td>
            <td><?= $descricao ?></td>
            <td><?= $nivelAprov ?></td>
            <td><a href="https://web.whatsapp.com/send?phone=<?= $telAgenda ?>" target="_blank" style="color: blue;"><?= $telAgenda ?></a></td>
            <td>
                <form action="" method="POST">
                    <a type="submit" class="btn-editar btn btn-sm btn-primary" href="editar_agendamento_aprovado.php?idAgenda=<?= $idAgenda ?>" role="button"><i class="far fa-edit"></i> Aprovar</a>
                    <a class="btn-editar btn btn-sm btn-danger" href="inserir_agendamento_aprovado.php?idAgenda=<?= $idAgenda ?>&reprovar=1" role="button"><i class="far fa-trash-alt"></i> Deletar</a>
            </td>
        </tr>
        <?php
    }
} else {
    // Caso não haja registros
    echo '<tr><td colspan="7">Nenhum pedido para agendamento encontrado.</td></tr>';
}
?>

            </tbody>
        </table>

        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
    Agendamento <b>' . $_GET['atualizado'] . '</b> aprovado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
    Agendamento <b>' . $_GET['excluido'] . '</b> excluido com sucesso!.
                </div>';
        }
        ?>
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