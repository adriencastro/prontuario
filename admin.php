<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


// Verificar se o usuário está logado
$estaLogado = isset($_SESSION['usuario']);



?>

<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'u470795851_trabalho';
$username = 'u470795851_trabalho'; // Ajuste conforme seu ambiente
$password = '#Ewdfh1k7'; // Ajuste conforme seu ambiente

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar os registros
    $sql = "SELECT id, nome, data_abertura, observacao FROM paciente ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/styles.css">
    <title>Área do Administrador</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .box {
            width: 48%;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .registro-lista, .professor-lista, .aluno-lista {
            margin-top: 20px;
        }

        .btn-edit, .btn-delete {
            margin-top: 10px;
            margin-right: 5px;
            padding: 8px 12px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        input[type="text"], input[type="email"], button[type="button"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button[type="button"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button[type="button"]:hover {
            background-color: #45a049;
        }

       footer {
        position: flex;
       }


    </style>


    <script>
        async function enviarFormulario(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Obtendo os dados do formulário
            const form = document.getElementById('formCadastro');
            const formData = new FormData(form);

            // Enviando os dados via fetch
            try {
                const resposta = await fetch('inserir_professor.php', {
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


    <script>
        async function enviarFormularioaluno(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Obtendo os dados do formulário
            const form = document.getElementById('formCadastroAluno');
            const formData = new FormData(form);

            // Enviando os dados via fetch
            try {
                const resposta = await fetch('inserir_aluno.php', {
                    method: 'POST',
                    body: formData
                });

                const resultado = await resposta.text(); // Recebe a resposta do PHP

                // Exibindo mensagem no elemento de aviso
                const aviso = document.getElementById('aviso2');
                aviso.innerHTML = resultado;
                aviso.style.color = "green"; // Cor do texto para sucesso
                aviso.style.display = "block";

                // Limpar o formulário após o sucesso
                form.reset();
            } catch (erro) {
                console.error("Erro ao enviar os dados:", erro);
                const aviso = document.getElementById('aviso2');
                aviso.innerHTML = "Ocorreu um erro ao tentar salvar o registro.";
                aviso.style.color = "red";
                aviso.style.display = "block";
            }
        }
    </script>







</head>
<body id="admin-body">
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-user-shield" id="nav_logo"> Administrador</i>

            <ul id="nav_list">
                <li class="nav-item">
                    <a href="index.php">Início</a>
                </li>
                <li class="nav-item active">
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




        </nav>
    </header>

    <div class="container">
        <div class="box" id="registro">
            <h2>Registros de Usuários</h2>


            <div class="registro-lista">
                

                                <?php foreach ($registros as $registro): ?>



<div class="registro-item" id="<?= htmlspecialchars($registro['id']); ?>">


                <p><strong>Id:</strong><?= htmlspecialchars($registro['id']); ?></p>
                <p><strong>Nome:</strong><?= htmlspecialchars($registro['nome']); ?></p>
                <p><strong>Data:</strong><?= htmlspecialchars($registro['data_abertura']); ?></p>
                <p><strong>Observação:</strong><?= htmlspecialchars($registro['observacao']); ?></p>

                <button class="btn-edit" onclick="editarRegistro(this)">Editar</button>





                <form action="excluir_usuario.php" method="POST" style="display: inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($registro['id']); ?>">
                    <button  class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                </form>


            </div>





                <?php endforeach; ?>



            </div>
        </div>

        <div class="box" id="gerenciar-professores">
            <h2>Gerenciar Professores</h2>



            <form id="formCadastro" onsubmit="enviarFormulario(event)">

        
        <label for="professornome">Nome do Professor:</label>
        <input type="text" id="professornome" name="professornome" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required><br><br>

        <button type="submit">Salvar</button>

 <p id="aviso" style="display: none;"></p> <!-- Elemento para exibir avisos -->



            </form>
            
            <div class="professor-lista"></div>






        <div  id="gerenciar-alunos">
            <h2>Gerenciar Alunos</h2>
            <form id="formCadastroAluno" onsubmit="enviarFormularioaluno(event)">

        
        <label for="nome">Nome do Aluno:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="turma">Turma:</label>
        <input type="text" id="turma" name="turma" required><br><br>

        <button type="submit">Salvar</button>

 <p id="aviso2" style="display: none;"></p> <!-- Elemento para exibir avisos -->



            </form>
            <div class="aluno-lista"></div>
        </div>


        </div>

        
    </div>

    <!-- <footer id="footer-adm">
        <img src="src/images/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">&copy; 2024 Uni Medical</span>
            <div class="social-media-buttons">
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-facebook"></i></a>
            </div>
        </div>
    </footer> -->



<script>
    async function excluirUsuario(id) {
        if (!confirm("Tem certeza que deseja excluir este usuário?")) {
            return;
        }

        try {
            // Faz a requisição AJAX para o script PHP
            const resposta = await fetch('excluir_usuario_ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            });

            const resultado = await resposta.json();

            if (resultado.success) {
                // Remove o registro da tabela
                const linha = document.getElementById(`registro-${id}`);
                if (linha) linha.remove();

                alert('Usuário excluído com sucesso!');
            } else {
                alert('Erro ao excluir o usuário: ' + (resultado.error || 'Erro desconhecido.'));
            }
        } catch (erro) {
            console.error('Erro ao excluir o usuário:', erro);
            alert('Erro ao processar a solicitação.');
        }
    }
</script>






</body>
</html>
