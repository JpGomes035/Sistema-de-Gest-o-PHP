<?php
include_once 'iniciar_sessao.php';
include_once('head.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Cadastro de usuário</title>
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

<body>
    <?php include_once 'menu.php'; ?>
    <div class="container" style="padding:20px 0;max-width: 800px;">
        <form action="inserir_usuario.php" method="POST">
            <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Cadastro de usuário</h4>
            <div class="form-group">
                <label>Nome</label>
                <input class="form-control" type="text" name="nome" placeholder="Digite o nome" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label>Sobrenome</label>
                <input class="form-control" type="text" name="sobrenome" placeholder="Digite o sobrenome" />
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Digite o e-mail para acessar o sistema" />

            </div>
            <p id="resultado"></p>

            <script>
                function validarEmail() {
                    var emailInput = document.getElementById("email");
                    var email = emailInput.value;
                    var resultado = document.getElementById("resultado");

                    // Verificar se o e-mail contém "@"
                    if (email.includes("@")) {
                        // Dividir o e-mail em partes (antes e depois do "@")
                        var partesEmail = email.split("@");

                        // Verificar se a segunda parte (domínio) contém ".com"
                        if (partesEmail[1].includes(".com")) {
                            resultado.innerText = "E-mail válido!";
                            return;
                        }
                    }
                    resultado.innerText = "E-mail inválido! Por favor, insira um e-mail válido com xxx@gmail.com.";
                }
            </script>


            <div class="form-group">
                <label>Senha</label>
                <input class="form-control" type="password" id="senha" name="senha" placeholder="Digite uma senha" />
            </div>

            <div class="form-group">
                <label>Repetir senha</label>
                <input class="form-control" type="password" id="senha2" name="senha2" placeholder="Digite a senha novamente" oninput="validaSenha(this)" />
                <small style="display:none" id="msg-erro">A senha precisa ser igual a senha digitada acima.</small>
            </div>

            <div class="form-group">
                <label>Nível de acesso</label>
                <select class="form-control" name="nivelUsuario">
                    <option value="1">Administrador</option>
                    <option value="2">Funcionário</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero">Qual o número do usuario?</label>
                <input type="text" class="form-control" id="telefoneUsuario" name="telefoneUsuario" placeholder="Ex: 35 8888-8888, sem o numero '9'" autocomplete="off" maxlength="11">
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
                        var telefoneInput = document.getElementById('telefoneUsuario');
                        telefoneInput.value = formatarTelefone(telefoneInput.value);
                    }

                    // Adiciona um listener para chamar a função de aplicar a máscara quando houver alteração no campo de telefone
                    document.getElementById('telefoneUsuario').addEventListener('input', aplicarMascaraTelefone);
                </script>

                <div class="form-group">
                    <label>CPF</label>
                    <input class="form-control" type="text" id="cpfUsuario" name="cpfUsuario" placeholder="Insira o CPF do usuário" oninput="formatarCPF(this)" maxlength="11" />
                </div>

                <script>
                    function formatarCPF(input) {
                        // Remove todos os caracteres não numéricos
                        var cpf = input.value.replace(/\D/g, '');

                        // Adiciona pontos e traço de formatação
                        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

                        // Atualiza o valor do campo de entrada
                        input.value = cpf;
                    }
                </script>
                 <div class="form-group">
                <label for="setor">Setor do User:</label>
                <select class="form-control" id="Setor" name="Setor" required>
                    <?php
                    //puxar todas as categorias cadastradas
                    $sqlSetor = "SELECT * FROM setor ORDER BY NomeSetor ASC";
                    $retornoSetor = mysqli_query($conexao, $sqlSetor);
                    while ($array = mysqli_fetch_array($retornoSetor, MYSQLI_ASSOC)) {
                        $idSetor = $array["idSetor"];
                        $NomeSetor = $array["NomeSetor"];
                        ?>
                        <option value="<?= $NomeSetor ?>">
                            <?= $NomeSetor ?>
                        </option>
                    <?php } ?>
                </select>
            </div>           
                <button type="submit" class="btn btn-success btn-sm btn-block" onclick="validarEmail()">Cadastrar <i class="fa fa-plus" aria-hidden="true"></i></button>
                <a href="listar_usuario.php" class="btn btn-success btn-sm btn-block">Lista de usuários</a>
        </form>
    </div>

    <?php include_once("footer.php"); ?>
    <script>
        function validaSenha(input) {
            if (input.value != document.getElementById('senha').value) {
                input.setCustomValidity('Repita a senha corretamente!');
                document.getElementById('msg-erro').style.display = "block"
            } else {
                input.setCustomValidity('');
                document.getElementById('msg-erro').style.display = "none"
            }
        }
    </script>
</body>

</html>