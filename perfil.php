<?php include_once 'iniciar_sessao.php'; ?>
<?php
// Inicialização de variáveis
$usuarioLogado = $_SESSION['usuario'];
?>

<?php include_once 'head.php'; ?>
<?php include_once 'menu.php'; ?>

<head>
  <link rel="stylesheet" href="perfil.css">
  <title>Perfil</title>
  <style>
    #status-container {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 9999;
    }

    .status-message {
      padding: 12px 24px;
      border-radius: 8px;
      color: #fff;
      font-weight: bold;
      font-family: Arial, sans-serif;
      opacity: 1;
      transition: opacity 0.5s ease-in-out;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .status-message.success {
      background-color: #28a745;
    }

    .status-message.error {
      background-color: #dc3545;
    }
  </style>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configurações do diretório de upload
  $targetDir = "upload-imagens/";
  $allowTypes = array('jpg', 'jpeg', 'png', 'jfif');

  include_once 'conexao.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'conexao.php';

    $statusMessage = '';

    if (isset($_POST['atualizar_status'])) {
      $novoStatus = $_POST['status'];
      $idUsuario = $_SESSION['usuario'];

      $sqlUpdateStatus = "UPDATE usuario SET Online = '$novoStatus' WHERE IdUsuario = '$idUsuario'";
      if (mysqli_query($conexao, $sqlUpdateStatus)) {
        $_SESSION['status_user'] = $novoStatus;
        $statusMessage = "<div class='status-message success'>Status atualizado com sucesso!</div>";
      } else {
        $statusMessage = "<div class='status-message error'>Erro ao atualizar status.</div>";
      }
    }
  }

  // Enviar imagem
  if (isset($_POST['enviar_imagem'])) {
    $targetDir = "upload-imagens/";
    $allowTypes = array('jpg', 'jpeg', 'png', 'jfif');

    if (!empty($_FILES['imagem']['name'])) {
      $fileName = basename($_FILES['imagem']['name']);
      $targetFilePath = $targetDir . $fileName;
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

      if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFilePath)) {
          $idUsuario = $_SESSION['usuario'];
          $sql = "INSERT INTO imagens (nome, id_usuario) VALUES ('$fileName', '$idUsuario')";
          $resultado = mysqli_query($conexao, $sql);

          if ($resultado) {
            echo "<br><b><i class='fa fa-check'></i> Imagem enviada com sucesso.</b>";
          } else {
            echo "<br><b><i class='fa fa-times'></i> Erro ao salvar no banco.</b>";
          }
        } else {
          echo "<br><b><i class='fa fa-times'></i> Erro ao fazer o upload.</b>";
        }
      } else {
        echo "<br><b><i class='fa fa-times'></i> Formato inválido.</b>";
      }
    } else {
      echo "<br><b><i class='fa fa-times'></i> Nenhum arquivo selecionado.</b>";
    }
  }
}

?>

<div class="form_mens-container">
  <div class="form_mens">
    <form action="inserir_mensagem.php" method="post">
      <input type="hidden" class="form-control" id="idMensagem" name="idMensagem">
      <label for="mensagem">Qual a mensagem inicial para os clientes?</label>
      <textarea name="mensagem" id="mensagem" rows="5" required
        placeholder="Mensagem que vai ser enviada para o cliente no WhatsApp assim que iniciada a conversa."></textarea>
      <input type="submit" value="Enviar">
    </form>
  </div>
</div>
<br><br>

<div class="retangulo">
  <h6>Clique duas vezes na imagem</h6>
  <?php
  $sql = "SELECT nome FROM imagens WHERE id_usuario = '$usuarioLogado' ORDER BY id_imagem DESC LIMIT 1";
  $resultado = mysqli_query($conexao, $sql);
  if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $imagem = $row['nome'];
    echo '<img src="upload-imagens/' . $imagem . '" alt="Logo da Empresa" ondblclick="ampliarImagem(this)">';
  } else {
    echo "<i class='fa fa-times' aria-hidden='true'></i> Nenhuma imagem encontrada.";
  }
  ?>
</div>

<!-- Formulário HTML para upload de imagem -->
<div class="form_img">
  <form action="" method="post" enctype="multipart/form-data">
    <label for="imagens"><b>Troque sua foto aqui: </b></label>
    <input type="file" name="imagem">
    <br>
    <input type="submit" name="enviar_imagem" value="Enviar">
  </form>

  <form action="" method="post">
    <label for="status"><b>Defina seu status:</b></label>
    <select name="status" id="status" required>
      <option value="1" <?= ($_SESSION['status_user'] == 1 ? 'selected' : '') ?>>🟢 Online</option>
      <option value="2" <?= ($_SESSION['status_user'] == 2 ? 'selected' : '') ?>>🟡 Ausente</option>
      <option value="3" <?= ($_SESSION['status_user'] == 3 ? 'selected' : '') ?>>🔴 Offline</option>
    </select>
    <input type="submit" name="atualizar_status" value="Atualizar Status">
  </form>
  <script>
    window.addEventListener("DOMContentLoaded", () => {
      const statusMsg = document.querySelector('.status-message');
      if (statusMsg) {
        setTimeout(() => {
          statusMsg.style.opacity = '0';
          setTimeout(() => {
            statusMsg.remove();
          }, 1000); // Aguarda o fade-out terminar
        }, 3000); // Espera 3s antes de iniciar o fade-out
      }
    });
  </script>
  <div id="idUsuario">
    <?php
    $sql = "SELECT Nome, Email, Online FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
    $retorno = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($retorno) > 0) {
      $row = mysqli_fetch_assoc($retorno);
      $nomeUser = $row["Nome"];
      $emailUser = $row["Email"];
      $_SESSION['status_user'] = $row["Online"]; // Armazena status em sessão

      echo "<b>User Logado:</b><br>";
      echo $nomeUser . " #" . $usuarioLogado;
      echo '<br>' . $emailUser;
    }

    ?>
  </div>
  <br>

  <?php
  $numero_suporte = '+55 35 8468-7649';
  $sql = "SELECT id_info, nome, cnpj, email, telefone, rua, cep, cidade FROM `informacoes`";
  $retorno = mysqli_query($conexao, $sql);

  while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
    $id_info = $array['id_info'];
    $nome = $array['nome'];
    $cnpj = $array['cnpj'];
    $email = $array['email'];
    $telefone = $array['telefone'];
    $rua = $array['rua'];
    $cep = $array['cep'];
    $cidade = $array['cidade'];

    $mensagem_suporte = 'Somos da ' . $nome . ' Precisamos de suporte técnico. Pode nos ajudar?';
  }
  ?>
  <?php if (!empty($statusMessage)): ?>
    <div id="status-container"><?= $statusMessage ?></div>
  <?php endif; ?>
  <br>
  <br>
  <a href="info_perfil.php" class="infoperfil"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Ver informações da empresa </b><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  <br>
  <a href="https://web.whatsapp.com/send?phone=<?= $numero_suporte ?>&text=<?= $mensagem_suporte ?>" class="infoperfil" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Suporte Técnico </b><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  <br>
  <a href="catalogo/catalogo.php" class="infoperfil" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Ver catálogo da empresa </b><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  <br>


</div>

<script>
  function ampliarImagem(img) {
    var src = img.src;
    var newWindow = window.open();
    newWindow.document.write('<img src="' + src + '" style="width:100%">');
    newWindow.document.title = "Imagem Ampliada";
  }
</script>