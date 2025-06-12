<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once 'head.php';
$IdUsuario = isset($_GET['IdUsuario']) ? $_GET['IdUsuario'] : null;
?>

<head>
    <title>Editar usuário</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
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
            font-weight: bold;
            line-height: 1.6;
        }
    </style>
</head>

<div style="padding: 20px 0; max-width: 800px" class="container">
    <h4 style="padding: 0 0 20px 0; margin-bottom: 35px;" class="border-bottom">Editar Usuário</h4>
    <?php
    $sql = "SELECT * FROM usuario WHERE IdUsuario = $IdUsuario";
    $retorno = mysqli_query($conexao, $sql);

    while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
        $IdUsuario = $array['IdUsuario'];
        $Nome = $array['Nome'];
        $Sobrenome = $array['Sobrenome'];
        $Email = $array['Email'];
        $NivelUsuario = $array['NivelUsuario'];
        $telefoneUsuario = $array['telefoneUsuario'];
        $cpfUsuario = $array['cpfUsuario'];
        $Status = $array['Status'];
        $Setor = $array['Setor'];
    ?>
        <form action="atualizar_usuario.php" method="POST">
            <input style="display: none" id="IdUsuario" name="IdUsuario" value="<?= $IdUsuario ?>">
            <div class="form-group">
                <label>Nome</label>
                <input class="form-control" type="text" name="nome" placeholder="Digite o seu nome" autocomplete="off" value="<?= $Nome ?>" />
            </div>

            <div class="form-group">
                <label>Sobrenome</label>
                <input class="form-control" type="text" name="sobrenome" placeholder="Digite o seu sobrenome" value="<?= $Sobrenome ?>" />
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Digite o seu e-mail para acessar o sistema" value="<?= $Email ?>" />
                <p id="resultado"></p>
            </div>

            <div class="form-group">
                <label>Nível de acesso</label>
                <select class="form-control" name="nivelUsuario">
                    <option value="1" <?= $NivelUsuario == 1 ? 'selected' : '' ?>>Administrador</option>
                    <option value="2" <?= $NivelUsuario == 2 ? 'selected' : '' ?>>Funcionário</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="Status">
                    <option value="Ativo" <?= $Status == "ativo" ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= $Status == "inativo" ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefoneUsuario">Qual o número do usuário?</label>
                <input type="text" class="form-control" id="telefoneUsuario" name="telefoneUsuario" placeholder="Ex: 35 8888-8888" value="<?= $telefoneUsuario ?>" maxlength="11">
                <script>
                    // Função para formatar o telefone
                    function formatarTelefone(telefone) {
                        // Remove todos os caracteres que não são números, exceto o sinal de adição inicial
                        telefone = telefone.replace(/\D/g, '').replace(/^(\+)?/, '$1');

                        // Verifica se o telefone possui 10 ou 11 dígitos
                        if (telefone.length === 10 || telefone.length === 11) {
                            // Aplica a máscara com o formato +55 (XX) XXXXX-XXXX
                            telefone = telefone.replace(/(\d{2})(\d{4,5})(\d{4})/, '+55 ($1) $2-$3');
                        }

                        return telefone;
                    }

                    // Função para aplicar a máscara quando o campo de telefone for preenchido
                    function aplicarMascaraTelefone() {
                        var telefoneInput = document.getElementById('telefoneUsuario');
                        telefoneInput.value = formatarTelefone(telefoneInput.value);
                    }

                    // Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
                    document.getElementById('telefoneUsuario').addEventListener('input', aplicarMascaraTelefone);
                </script>
            </div>
            <div class="form-group">
                <label>CPF</label>
                <input class="form-control" type="text" id="cpfUsuario" name="cpfUsuario" placeholder="Insira o CPF do usuário" maxlength="14" value="<?= $cpfUsuario ?>" oninput="formatarCPF(this)" />
            </div>
            <!-- Campo de senha -->
            <div class="form-group">
                <label>Senha</label>
                <input class="form-control" type="password" id="senha" name="senha" placeholder="Digite uma senha" />
            </div>

            <div class="form-group">
                <label>Repetir senha</label>
                <input class="form-control" type="password" id="senha2" name="senha2" placeholder="Digite a senha novamente" oninput="validaSenha(this)" />
                <small style="display:none" id="msg-erro">A senha precisa ser igual a senha digitada acima.</small>
            </div>
            <!-- Mensagem de erro/sucesso -->
            <div id="msg-erro" style="display: none; color: red;">Repita a senha corretamente!</div>
            <div class="form-group">
                <label for="setor">Setor do User:</label>
                <select class="form-control" id="Setor" name="Setor" required>
                    <?php
                    // Puxar todas as categorias cadastradas
                    $sqlSetor = "SELECT * FROM setor ORDER BY NomeSetor ASC";
                    $retornoSetor = mysqli_query($conexao, $sqlSetor);
                    while ($array = mysqli_fetch_array($retornoSetor, MYSQLI_ASSOC)) {
                        $idSetor = $array["idSetor"];
                        $NomeSetor = $array["NomeSetor"];
                        // Verificar se o setor atual do usuário corresponde à opção
                        $selected = ($NomeSetor == $Setor) ? 'selected' : '';
                    ?>
                        <option value="<?= $NomeSetor ?>" <?= $selected ?>>
                            <?= $NomeSetor ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar</button>
        </form>
    <?php } ?>
    <!-- Botão de voltar -->
    <a href="listar_usuario.php" class="btn btn-primary btn-sm btn-block">Voltar</a>
</div>

<?php include_once("footer.php"); ?>

<script>
    // Função para formatar o CPF
    function formatarCPF(input) {
        // Remove todos os caracteres não numéricos
        var cpf = input.value.replace(/\D/g, '');

        // Adiciona pontos e traço de formatação
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

        // Atualiza o valor do campo de entrada
        input.value = cpf;
    }
</script>

<script>
    // Função para validar a senha
    function validaSenha(input) {
        if (input.value != document.getElementById('senha').value) {
            input.setCustomValidity('Repita a senha corretamente!');
            document.getElementById('msg-erro').style.display = "block";
        } else {
            input.setCustomValidity('');
            document.getElementById('msg-erro').style.display = "none";
        }
    }
</script>
