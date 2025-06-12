<?php
include_once '../iniciar_sessao.php';
include_once '../head.php';

// Nome do usuário logado
$usuarioLogado = $_SESSION["usuario"];
$sql = "SELECT Nome FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
$retorno = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($retorno);
$nomeUsuario = $array['Nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Chat de Grupos</title>
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <link rel="stylesheet" href="stylegp.css">
</head>

<body>
    <div id="container">
        <div id="group-list-container">
            <h3>Meus Grupos</h3>
            <ul id="group-list-items"></ul>

            <h3>Criar Grupo</h3>
            <div id="user-checkboxes"></div>
            <input type="text" id="nome-grupo" placeholder="Nome do grupo" style="width: 90%; margin: 10px 0;">
            <button onclick="criarGrupoSelecionado()">Criar Grupo</button>
            <a href="../home.php" class="back-button" style="display:block; margin-top:15px;">Voltar</a>
            <a href="chat.php" class="back-button" style="display:block; margin-top:15px;">Chat individual</a>
        </div>

        <!-- Modal para editar grupo -->
        <div id="edit-group-modal" class="modal" style="display:none;">
            <div class="modal-content">
                <span id="close-modal" class="close">&times;</span>

                <form action="editar_grupo.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="group_id" value="<?= $group_id ?>"> <!-- ID do grupo -->

                    <h3>Editar Grupo</h3>

                    <img id="preview-photo" src="upload-grupo/<?= $group_photo ?>" alt="Foto do grupo" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">

                    <label for="group-photo">Alterar foto do grupo:</label><br>
                    <input type="file" id="group-photo" name="group_photo" accept="image/*"><br><br>

                    <label for="group-name">Nome do grupo:</label><br>
                    <input type="text" id="group-name" name="group_name" value="<?= htmlspecialchars($group_name) ?>" style="width: 100%; padding: 8px; margin-bottom: 15px;" required>

                    <button type="submit" style="padding: 10px 20px; background-color: #007bff; border: none; color: white; border-radius: 8px; cursor: pointer;">
                        Salvar Alterações
                    </button>
                </form>
            </div>
        </div>

        <div id="chat-container">
            <div id="header">
                Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!<br>
                <span id="current-conversation">Selecione um grupo para conversar</span>
            </div>
            <!-- Ícone para abrir os membros do grupo -->
            <button id="toggle-members-btn" onclick="toggleGroupMembers()" style="background: none; border: none; cursor: pointer;">
                👥 <!-- Ou use <i class="fas fa-users"></i> se usar FontAwesome -->
            </button>

            <!-- Conteúdo oculto inicialmente -->
            <div id="group-members" style="display: none; margin-top: 20px;">
                <h4>Membros do grupo:</h4>
                <ul id="group-members-list" style="list-style: none; padding-left: 0;"></ul>
            </div>

            <button id="edit-group-btn" class="btn-edit-group" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer;">
                Editar Grupo
            </button>

            <div id="chat-box"></div>
            <div id="typing-indicator" style="display:none;"><?php echo htmlspecialchars($nomeUsuario); ?> está digitando...</div>
            <div id="input-container" style="display:none;">
                <input type="text" id="message-input" placeholder="Digite sua mensagem">
                <div class="input-file-container">
                    <label for="file-input" class="file-label">
                        <span>📎 Enviar arquivo</span>
                    </label>
                    <input type="file" id="file-input" class="file-input">
                    <span class="file-name">Nenhum arquivo selecionado</span>
                </div>

                <button onclick="sendMessage()">Enviar</button>
            </div>
        </div>

    </div>


    <script>
        const usuarioLogado = <?php echo json_encode($usuarioLogado); ?>;
        const nomeUsuario = <?php echo json_encode($nomeUsuario); ?>;
        let selectedGroupId = null;

        // Carrega os grupos do usuário
        function fetchGroups() {
            fetch('fetch_groups.php')
                .then(res => res.json())
                .then(groups => {
                    const groupList = document.getElementById('group-list-items');
                    groupList.innerHTML = '';
                    if (groups.length === 0) {
                        groupList.innerHTML = '<li>Nenhum grupo encontrado.</li>';
                        return;
                    }

                    groups.forEach(g => {
                        const li = document.createElement('li');
                        li.style.cursor = 'pointer';
                        li.style.display = 'flex';
                        li.style.alignItems = 'center';
                        li.style.marginBottom = '10px';

                        const img = document.createElement('img');
                        img.src = g.imagem_grupo || 'default-group.png';
                        img.alt = 'Foto do grupo';
                        img.style.width = '32px';
                        img.style.height = '32px';
                        img.style.borderRadius = '50%';
                        img.style.marginRight = '10px';
                        img.style.objectFit = 'cover';

                        const span = document.createElement('span');
                        span.textContent = g.nome;

                        li.appendChild(img);
                        li.appendChild(span);
                        li.onclick = () => selectGroup(g.id, g.nome, g.imagem_grupo);
                        groupList.appendChild(li);
                    });
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const closeBtn = document.getElementById("close-modal");
            const modal = document.getElementById("edit-group-modal");

            closeBtn.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // (Opcional) Fechar o modal ao clicar fora do conteúdo
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });

        // Seleciona um grupo para chat
        // Atualizado: Selecionar grupo agora define a imagem para edição corretamente
        function selectGroup(groupId, groupName, groupPhoto = null) {
            selectedGroupId = groupId;
            document.getElementById('current-conversation').innerText = `Grupo: ${groupName}`;
            document.getElementById('input-container').style.display = 'block';

            // Preenche o modal de edição
            document.querySelector('input[name="group_id"]').value = groupId;
            document.getElementById('group-name').value = groupName;
            document.getElementById('preview-photo').src = groupPhoto || 'default-group.png';

            fetchGroupMessages();
            fetchGroupUsers(groupId); // <-- Adiciona essa linha
        }

        let groupMembersVisible = false;
        let groupUsersLoaded = false; // evita múltiplas requisições

        function toggleGroupMembers() {
            const container = document.getElementById('group-members');
            groupMembersVisible = !groupMembersVisible;

            if (groupMembersVisible) {
                container.style.display = 'block';
                if (!groupUsersLoaded) {
                    const groupId = 1; // Substitua pelo ID correto dinamicamente
                    fetchGroupUsers(groupId);
                    groupUsersLoaded = true;
                }
            } else {
                container.style.display = 'none';
            }
        }

        function fetchGroupUsers(groupId) {
            fetch(`fetch_usuarios_grupo.php?group_id=${groupId}`)
                .then(res => res.json())
                .then(users => {
                    const list = document.getElementById('group-members-list');
                    list.innerHTML = '';

                    if (users.length === 0) {
                        list.innerHTML = '<li>Nenhum membro encontrado.</li>';
                        return;
                    }

                    users.forEach(user => {
                        const li = document.createElement('li');
                        li.style.display = 'flex';
                        li.style.alignItems = 'center';
                        li.style.marginBottom = '8px';

                        const img = document.createElement('img');
                        img.src = user.imagem;
                        img.alt = user.name;
                        img.style.width = '32px';
                        img.style.height = '32px';
                        img.style.borderRadius = '50%';
                        img.style.marginRight = '10px';

                        const span = document.createElement('span');
                        span.textContent = user.name;

                        li.appendChild(img);
                        li.appendChild(span);
                        list.appendChild(li);
                    });
                });
        }

        document.getElementById('edit-group-btn').addEventListener('click', function() {
            if (!selectedGroupId) {
                alert('Selecione um grupo primeiro.');
                return;
            }
            document.getElementById('edit-group-modal').style.display = 'flex';
        });

        // Busca as mensagens do grupo selecionado
        function fetchGroupMessages() {
            if (!selectedGroupId) return;

            fetch(`get_messages_group.php?group_id=${selectedGroupId}`)
                .then(res => res.json())
                .then(messages => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';

                    for (let i = messages.length - 1; i >= 0; i--) {
                        const msg = messages[i];
                        const messageClass = msg.sender_id == usuarioLogado ? 'sent' : 'received';
                        let messageHTML = `
                    <div class="message ${messageClass}">
                        <strong>${msg.username}:</strong>
                        <span>${msg.message}</span>
                        <div class="timestamp">${new Date(msg.timestamp).toLocaleString('pt-BR')}</div>
                `;

                        if (msg.file_path) {
                            const fileName = msg.file_path.split('/').pop();
                            messageHTML += `<br><a href="${msg.file_path}" target="_blank">${fileName}</a>`;
                        }

                        messageHTML += `</div>`;
                        chatBox.insertAdjacentHTML('afterbegin', messageHTML);
                    }

                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }

        // Envia mensagem para o grupo
        function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const fileInput = document.getElementById('file-input');
            const message = messageInput.value.trim();
            const file = fileInput.files[0];

            if (!message && !file) {
                alert('Digite uma mensagem ou selecione um arquivo.');
                return;
            }
            if (!selectedGroupId) {
                alert('Selecione um grupo para enviar mensagem.');
                return;
            }

            const formData = new FormData();
            formData.append('username', nomeUsuario);
            formData.append('message', message);
            formData.append('id_grupo', selectedGroupId);

            if (file) {
                formData.append('file', file);
            }

            fetch('send_message_group.php', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json())
                .then(() => {
                    messageInput.value = '';
                    fileInput.value = '';
                    document.querySelector('.file-name').textContent = '';
                    fetchGroupMessages();
                });
        }

        // Carrega os usuários para seleção na criação do grupo
        function carregarCheckboxUsuarios() {
            fetch('fetch_users.php')
                .then(res => res.json())
                .then(users => {
                    const container = document.getElementById('user-checkboxes');
                    container.innerHTML = '';
                    users.forEach(user => {
                        if (user.id != usuarioLogado) {
                            const wrapper = document.createElement('div');
                            wrapper.style.display = 'flex';
                            wrapper.style.alignItems = 'center';
                            wrapper.style.marginBottom = '8px';

                            const img = document.createElement('img');
                            img.src = user.imagem;
                            img.alt = user.name;
                            img.style.width = '32px';
                            img.style.height = '32px';
                            img.style.borderRadius = '50%';
                            img.style.marginRight = '10px';

                            const label = document.createElement('label');
                            label.innerHTML = `
                        <input type="checkbox" class="checkbox-membro" value="${user.id}"> 
                        ${user.name} (${user.Setor})
                    `;

                            wrapper.appendChild(img);
                            wrapper.appendChild(label);
                            container.appendChild(wrapper);
                        }
                    });
                });
        }


        // Cria grupo com os membros selecionados
        function criarGrupoSelecionado() {
            const nomeGrupo = document.getElementById('nome-grupo').value.trim();
            const checkboxes = document.querySelectorAll('.checkbox-membro:checked');
            const membros = Array.from(checkboxes).map(cb => parseInt(cb.value));

            if (!nomeGrupo) {
                alert('Informe um nome para o grupo.');
                return;
            }
            if (membros.length < 1) {
                alert('Selecione pelo menos 1 membro para o grupo.');
                return;
            }

            fetch('criar_grupo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nomeGrupo,
                        membros
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Grupo criado com sucesso!');
                        document.getElementById('nome-grupo').value = '';
                        document.querySelectorAll('.checkbox-membro').forEach(cb => cb.checked = false);
                        fetchGroups();
                    } else {
                        alert('Erro ao criar grupo: ' + data.message);
                    }
                });
        }

        // Atualiza o nome do arquivo selecionado
        document.getElementById('file-input').addEventListener('change', function() {
            const fileNameContainer = document.querySelector('.file-name');
            if (this.files.length > 0) {
                fileNameContainer.textContent = this.files[0].name;
            } else {
                fileNameContainer.textContent = '';
            }
        });


        // Atualiza mensagens a cada 2 segundos
        setInterval(() => {
            if (selectedGroupId) {
                fetchGroupMessages();
            }
        }, 2000);

        // Inicializa
        window.onload = function() {
            fetchGroups();
            carregarCheckboxUsuarios();
        };
    </script>