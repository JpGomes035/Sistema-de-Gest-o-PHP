<?php

include_once 'conexao.php';
include_once('password.php');
?>
<?php
    $sql = "SELECT Nome, Email FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
    $retorno = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($retorno) > 0) {
      $row = mysqli_fetch_assoc($retorno);
      $nomeUser = $row["Nome"];
      $emailUser = $row["Email"];
    }
?>