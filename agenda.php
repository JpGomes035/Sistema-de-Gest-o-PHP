<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
include_once 'conexao.php';
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="agenda.css">
<head>
    <title>Agenda</title>
</head>
<body>
    <?php include_once 'menu.php'; ?>

    <div style="padding:20px 0" class="container">
        <h1>Minha Agenda</h1>
        <!-- Formulário para adicionar novo evento -->
        <form method="post" action="adicionar_evento.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>

            <label for="resp">Responsável</label>
            <select class="form-control" id="resp" name="resp">
                <?php
                $sqluser = "SELECT * FROM usuario ORDER BY Nome ASC";
                $usuario = mysqli_query($conexao, $sqluser);
                while ($array = mysqli_fetch_array($usuario, MYSQLI_ASSOC)) {
                    $IdUsuario = $array["IdUsuario"];
                    $nome = $array["Nome"];
                ?>
                    <option><?= $nome ?></option>
                <?php } ?>
            </select>
            <br>

            <label for="data">Data:</label>
            <input type="date" name="data" id="data" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required></textarea>

            <div class="form-group">
                <label for="numero">Qual o número para contato?</label>
                <input type="text" class="form-control" id="telAgenda" name="telAgenda"
                    placeholder="Ex: 35 8888-8888, sem o numero '9'" autocomplete="off" maxlength="11">
                <script>
                    // Função para formatar o telefone
                    function formatarTelefone(telefone) {
                        // Remove todos os caracteres que não são números
                        telefone = telefone.replace(/\D/g, '');

                        // Verifica se o telefone possui 10 ou 11 dígitos
                        if (telefone.length === 10 || telefone.length === 11) {
                            // Aplica a máscara com o formato +55 (XX) XXXXX-XXXX
                            telefone = telefone.replace(/(\d{2})(\d{4,5})(\d{4})/, '+55 ($1) $2-$3');
                        }

                        return telefone;
                    }

                    // Função para aplicar a máscara quando o campo de telefone for preenchido
                    function aplicarMascaraTelefone() {
                        var telefoneInput = document.getElementById('telAgenda');
                        telefoneInput.value = formatarTelefone(telefoneInput.value);
                    }

                    // Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
                    document.getElementById('telAgenda').addEventListener('input', aplicarMascaraTelefone);
                </script>
            <input type="submit" value="Adicionar Evento">

            <a href="home.php" style="padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;">Voltar</a>
        </form>
        <br>
        <br>
        <h3 style="margin-bottom:30px">Eventos agendados</h3>
        <?php
        include_once 'conexao.php';
        // Configuração da paginação
        $registrosPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $offset = ($paginaAtual - 1) * $registrosPorPagina;

        $sql = "SELECT idAgenda, titulo, resp, data, descricao, telAgenda FROM `agenda` where nivelAprov = 'ativo' LIMIT $offset, $registrosPorPagina";
        $retorno = mysqli_query($conexao, $sql);

        $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT idAgenda FROM `agenda`"));
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        if ($totalPaginas > 1) {
            echo '<div class="pagination">';
            echo '<ul class="pagination-list">';
            if ($paginaAtual > 1) {
                echo '<li class="pagination-item"><a class="pagination-link" href="?pagina=' . ($paginaAtual - 1) . '">Anterior</a></li>';
            }
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo '<li class="pagination-item"><a class="pagination-link' . ($paginaAtual == $i ? ' active' : '') . '" href="?pagina=' . $i . '">' . $i . '</a></li>';
            }
            if ($paginaAtual < $totalPaginas) {
                echo '<li class="pagination-item"><a class="pagination-link" href="?pagina=' . ($paginaAtual + 1) . '">Próxima</a></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Data</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //puxando os dados da SQL
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $idAgenda = $array['idAgenda'];
                    $titulo = $array['titulo'];
                    $resp = $array['resp'];
                    $data = $array['data'];
                    $telAgenda = $array['telAgenda'];
                    $descricao = $array['descricao'];


                    // Verifica se a descrição excede um determinado número de caracteres
                    $maxCaracteres = 25;

                    if (strlen($descricao) > $maxCaracteres) {
                        $descricaoExcedido = true;
                        $descricaoResumida = substr($descricao, 0, $maxCaracteres) . '...';
                    } else {
                        $descricaoExcedido = false;
                        $descricaoResumida = '';
                    }

                ?>
                    <?php
                    //trazendo as informações da mensagem automatica cadastrada pro cliente no perfil
                    $sqlmensagem = "SELECT idMensagem, mensagem FROM `mensagem` ORDER BY idMensagem DESC LIMIT 1";
                    $retornomensagem = mysqli_query($conexao, $sqlmensagem);
                    ?>
                    <tr>
                        <td>
                            <?= $idAgenda ?>
                        </td>
                        <td>
                            <?= $titulo ?>
                        </td>
                        <td>
                            <?= $resp ?>
                        </td>
                        <?php
                        $data_original = $data;
                        $timestamp = strtotime($data_original);
                        $data_formatada = date("d/m/Y", $timestamp);
                        ?>
                        <td>
                            <?= $data_formatada ?>
                        </td>
                        <?php
                        $mensagem = ""; // Define a variável $mensagem com um valor vazio inicialmente
                        if ($row = mysqli_fetch_assoc($retornomensagem)) {
                            $mensagem = $row['mensagem']; // Atribui o valor da coluna 'mensagem' ao $mensagem se existir um resultado da consulta
                        }
                        ?>
                        <td><a href="https://web.whatsapp.com/send?phone=<?= $telAgenda ?>&text=<?= $mensagem ?>" target="_blank" style="color: red;">
                                <?= $telAgenda ?>
                            </a></td>

                        <td class="descricao-expandir">
                            <?= $descricao ?>
                        <td></a>
                            <a class="btn-editar btn btn-sm btn-danger" href="agenda_concluida.php?idAgenda=<?= $idAgenda ?>" role="button"><i class="fa fa-check" aria-hidden="true"></i> Concluída</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                Agenda <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Pendência <b>' . $_GET['excluido'] . '</b> concluída com sucesso!.
                </div>';
        }
        ?>
    </div>


    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function() {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>
    <?php include_once('footer.php') ?>
</body>

</html>