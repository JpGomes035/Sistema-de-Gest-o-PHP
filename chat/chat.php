<?php
include_once '../iniciar_sessao.php';
include_once '../head.php';

// Conectar ao banco de dados para obter o nome do usuário
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
    <title>Chat interno</title>
    <link rel="shortcut icon" href="../monitor.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="container">
        <div id="user-list">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Buscar usuário...">
                <select id="sector-filter">
                    <option value="">Todos os setores</option>
                    <!-- setores serão carregados dinamicamente -->
                </select>
            </div>
            <ul id="user-list-items"></ul>
            <div id="user-list-footer">
                <a href="../home.php" class="back-button">Voltar</a>
                <a href="chat_grupo.php" class="back-button" style="margin-left: 10px;">Chat em Grupo</a>
            </div>
        </div>

        <div id="chat-container">
            <div id="header">
                Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>! <br> <span id="current-conversation"></span>
            </div>
            <div id="chat-box"></div>
            <div id="typing-indicator" style="display:none;"><?php echo htmlspecialchars($nomeUsuario); ?> está digitando...</div>
            <div id="input-container">
                <input type="text" id="message-input" placeholder="Digite sua mensagem">
                <div class="input-file-container">
                    <label for="file-input">
                        <span>Enviar arquivo</span>
                    </label>
                    <input type="file" id="file-input">
                    <span class="file-name"></span>
                </div>
                <button onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('file-input').addEventListener('change', function() {
            const fileInput = document.getElementById('file-input');
            const fileNameContainer = document.querySelector('.file-name');
            if (fileInput.files.length > 0) {
                fileNameContainer.textContent = fileInput.files[0].name;
            } else {
                fileNameContainer.textContent = '';
            }
        });

        let typingTimeout;
        let selectedUserId = null;
        let selectedUserName = null;
        const username = '<?php echo addslashes($nomeUsuario); ?>';
        const userIdLogged = '<?php echo $usuarioLogado; ?>';

        function fetchMessages() {
            if (!selectedUserId) return;
            fetch(`fetch_messages.php?receiver_id=${selectedUserId}`)
                .then(response => response.json())
                .then(data => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';

                    for (let i = data.length - 1; i >= 0; i--) {
                        const msg = data[i];
                        const messageClass = msg.sender_id == userIdLogged ? 'sent' : 'received';
                        let messageElement = `
                        <div class="message ${messageClass}">
                            <strong>${msg.username}:</strong>
                            <span>${msg.message}</span>
                            <div class="timestamp">${new Date(msg.timestamp).toLocaleString('pt-BR', { timeZone: 'America/Sao_Paulo' })}</div>
                        `;

                        if (msg.file_path) {
                            const fileName = msg.file_path.split('/').pop();
                            messageElement += `<br><a href="${msg.file_path}" target="_blank">${fileName}</a>`;
                        }

                        messageElement += `</div>`;
                        chatBox.insertAdjacentHTML('afterbegin', messageElement);
                    }

                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }

        function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const fileInput = document.getElementById('file-input');
            const message = messageInput.value.trim();
            const file = fileInput.files[0];

            if (!selectedUserId) {
                alert('Selecione um usuário para conversar.');
                return;
            }
            if (!message && !file) {
                alert('Digite uma mensagem ou selecione um arquivo para enviar.');
                return;
            }

            const formData = new FormData();
            formData.append('username', username);
            formData.append('message', message);
            formData.append('receiver_id', selectedUserId);

            if (file) {
                formData.append('file', file);
            }

            fetch('send_message.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(() => {
                    messageInput.value = '';
                    fileInput.value = '';
                    document.querySelector('.file-name').textContent = '';
                    fetchMessages();
                    hideTypingIndicator();
                })
                .catch(err => console.error('Erro ao enviar mensagem:', err));
        }

        function showTypingIndicator() {
            document.getElementById('typing-indicator').style.display = 'block';
        }

        function hideTypingIndicator() {
            document.getElementById('typing-indicator').style.display = 'none';
        }

        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            } else {
                clearTimeout(typingTimeout);
                showTypingIndicator();
                typingTimeout = setTimeout(hideTypingIndicator, 2000);
            }
        });

        function fetchUsers() {
            fetch('fetch_users.php')
                .then(response => response.json())
                .then(data => displayUsers(data))
                .catch(error => console.error('Erro ao buscar usuários:', error));
        }

        function displayUsers(users) {
            const userList = document.getElementById('user-list-items');
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const sectorFilter = document.getElementById('sector-filter').value;

            const filteredUsers = users.filter(user => {
                const matchesSearch = user.name.toLowerCase().includes(searchInput);
                const matchesSector = sectorFilter === '' || user.Setor === sectorFilter;
                // Excluir o próprio usuário da lista
                return matchesSearch && matchesSector && user.id != userIdLogged;
            });

            userList.innerHTML = filteredUsers.map(user => {
                let statusClass = '';
                if (user.Online == 1) statusClass = 'status-online';
                else if (user.Online == 2) statusClass = 'status-away';
                else statusClass = 'status-offline';

                return `
                    <li onclick="selectUser(${user.id}, '${user.name}')">
                        <div class="user-info">
                            <img src="${user.imagem}" alt="Foto do usuário" class="user-avatar" ondblclick="ampliarImagem(this)">
                            <div>
                                <strong>${user.name}</strong>
                                <div class="user-sector">Setor: ${user.Setor}</div>
                            </div>
                        </div>
                        <span class="status-indicator ${statusClass}"></span>
                    </li>
                `;
            }).join('');
        }

        function selectUser(userId, userName) {
            selectedUserId = userId;
            selectedUserName = userName;
            document.getElementById('current-conversation').innerText = `Conversando com ${selectedUserName}`;
            fetchMessages();
        }

        function fetchSectors() {
            fetch('fetch_sectors.php')
                .then(response => response.json())
                .then(data => {
                    const sectorFilter = document.getElementById('sector-filter');
                    sectorFilter.innerHTML = '<option value="">Todos os setores</option>';
                    data.forEach(sector => {
                        const option = document.createElement('option');
                        option.value = sector.NomeSetor;
                        option.textContent = sector.NomeSetor;
                        sectorFilter.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar setores:', error));
        }

        // Para ampliar imagem (função que estava no seu código)
        function ampliarImagem(img) {
            const src = img.src;
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.cursor = 'pointer';
            modal.onclick = () => modal.remove();

            const imagem = document.createElement('img');
            imagem.src = src;
            imagem.style.maxWidth = '90%';
            imagem.style.maxHeight = '90%';

            modal.appendChild(imagem);
            document.body.appendChild(modal);
        }

        document.getElementById('search-input').addEventListener('input', fetchUsers);
        document.getElementById('sector-filter').addEventListener('change', fetchUsers);

        window.onload = function() {
            fetchSectors();
            fetchUsers();

            setInterval(() => {
                fetchMessages();
            }, 1000);
        };

        // Inatividade automático (se quiser manter)
        let inatividadeTimeout;

        function iniciarTemporizadorInatividade() {
            inatividadeTimeout = setTimeout(realizarLogoff, 600000); // 10 min
        }

        function resetarTemporizadorInatividade() {
            clearTimeout(inatividadeTimeout);
            iniciarTemporizadorInatividade();
        }

        function realizarLogoff() {
            window.location.href = "../sair.php";
        }

        document.addEventListener('mousemove', resetarTemporizadorInatividade);
        document.addEventListener('keydown', resetarTemporizadorInatividade);
        iniciarTemporizadorInatividade();
    </script>
</body>

</html>