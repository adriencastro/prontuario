<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}



// Verificar se o usuário está logado
$estaLogado = isset($_SESSION['usuario']);



?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/styles.css">
    <title>Trabalho segunda</title>




    <script>
        async function enviarFormulario(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Obtendo os dados do formulário
            const form = document.getElementById('formCadastro');
            const formData = new FormData(form);

            // Enviando os dados via fetch
            try {
                const resposta = await fetch('inserir_paciente.php', {
                    method: 'POST',
                    body: formData
                });

                const resultado = await resposta.text(); // Recebe a resposta do PHP

                // Exibindo mensagem no elemento de aviso
                const aviso = document.getElementById('aviso');
                aviso.innerHTML = resultado;
                aviso.style.color = "green"; // Cor do texto para sucesso
                aviso.style.display = "block";

                // Limpar o formulário após o sucesso
                form.reset();
            } catch (erro) {
                console.error("Erro ao enviar os dados:", erro);
                const aviso = document.getElementById('aviso');
                aviso.innerHTML = "Ocorreu um erro ao tentar salvar o registro.";
                aviso.style.color = "red";
                aviso.style.display = "block";
            }
        }
    </script>






</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-user-doctor" id="nav_logo"> Medical Uni Aluno</i>

            <ul id="nav_list">
                <li class="nav-item active">
                    <a href="#home">Início</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="aluno.php">Aluno</a>
                </li>
                <li class="nav-item">
                    <a href="professor.php">Professor</a>
                </li>
            </ul>



            <?php if ($estaLogado): ?>
                <p>Logado como: <strong><?= htmlspecialchars($_SESSION['usuario']); ?></strong></p>
                <a href="logout.php"><button id="logoutButton" class="btn-default">Logout</button> </a>
            <?php else: ?>
                <a href="login.php"><button id="logoutButton" class="btn-default">Login</button></a>
            <?php endif; ?>




            <div id="loginForm">
                <input type="text" placeholder="Usuário" id="username">
                <input type="password" placeholder="Senha" id="password">
                <button type="button" id="submitLogin">Entrar</button>
            </div>

            <button id="mobile_btn">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Prontuário de Usuários -->
    <div class="container">
        <h1>Prontuário de Usuários</h1>
        

    <form id="formCadastro" onsubmit="enviarFormulario(event)">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="data_abertura">Data:</label>
        <input type="date" id="data_abertura" name="data_abertura" required><br><br>

        <label for="observacao">Observação:</label>
        <textarea id="observacao" name="observacao" rows="4" cols="50"></textarea><br><br>

        <button type="submit">Salvar</button>
    </form>


 <p id="aviso" style="display: none;"></p> <!-- Elemento para exibir avisos -->






        <section id="registro">
            <h2>Registros</h2>
            <div class="registro-lista">
                
            </div>
        </section>
    </div>

    <footer>
        <img src="src/images/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">
                &copy 2024 Uni Med
            </span>
            <div class="social-media-buttons">
                <a href="">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="src/javascript/script.js"></script>

    <!-- prontuário -->
    <script>
        document.getElementById('prontuario-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const nome = document.getElementById('nome').value;
            const data_abertura = document.getElementById('data_abertura').value;
            const observacao = document.getElementById('observacao').value;

            const registroItem = document.createElement('div');
            registroItem.classList.add('registro-item');
            registroItem.innerHTML = `
                <p><strong>Nome:</strong> ${nome}</p>
                <p><strong>Data:</strong> ${data_abertura}</p>
                <p><strong>Observação:</strong> ${observacao}</p>
            `;
            document.querySelector('.registro-lista').appendChild(registroItem);
            document.getElementById('prontuario-form').reset();
        });

        document.getElementById('loginButton').addEventListener('click', function() {
            const loginForm = document.getElementById('loginForm');
            loginForm.classList.toggle('show');
        });
    </script>
</body>
</html>
