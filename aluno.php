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
    $sql = "SELECT id, nome, data_abertura, data_nascimento, observacao FROM paciente ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/styles.css">
    <title>Área do Aluno</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff9ea;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 40px;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sidebar {
            width: 30%;
            background-color: #c7c42a33;
            color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
            font-size: 16px;
        }

        .sidebar ul li a {
            color: rgb(0, 0, 0);
            text-decoration: none;
            transition: color 0.3s;
        }

        .sidebar .card {
            background-color: #1abc9c;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar .card:hover {
            background-color: #16a085;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content h2 {
            margin-bottom: 20px;
        }

        .card {
            padding: 20px;
            background-color: #f4f4f4;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin: 0 0 10px;
        }

        .new-session {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .form-adicionar-paciente {
            display: none;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-adicionar-paciente input,
        .form-adicionar-paciente textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-adicionar-paciente button {
            background-color: #3498db;
            padding: 12px 24px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-adicionar-paciente button:hover {
            background-color: #2980b9;
        }

        footer {
            
            mask-position: flex;
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



        

    </style>
</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-user" id="nav_logo"> Área do Aluno</i>
            <ul id="nav_list">
                <li class="nav-item">
                    <a href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php">Admin</a>
                </li>
                <li class="nav-item active">
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



    </header>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>Pacientes:</h1>


            <!-- Novo Paciente Card -->
            <div class="card novo-paciente" onclick="mostrarFormulario()">
                <h3>Novo Paciente</h3>
                <p>Clique para adicionar um novo paciente</p>
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <h1>Lista de Pacientes:</h1>


<?php foreach ($registros as $registro): ?>

            <div class="registro-item">
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

        
        <div class="main-content">
            
            <div id="pacientesList"></div>

            
            <div class="form-adicionar-paciente" id="formAdicionarPaciente">
                <h3>Adicionar Novo Paciente</h3>
                    <form id="formCadastro" onsubmit="enviarFormulario(event)">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="data_abertura">Data do Cadastro:</label>
                    <input type="date" id="data_abertura" name="data_abertura" required>

                    <label for="data_nascimento">Idade:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required>
                    
                    <label for="observacao">Observações:</label>
                    <textarea id="observacao" name="observacao" rows="4"></textarea>
                    

                    <button type="submit">Salvar Paciente</button>
                </form>


 <p id="aviso" style="display: none;"></p> <!-- Elemento para exibir avisos -->



            </div>

            <!-- Nova Sessão -->
            <div class="new-session">
                <h3>Nova Sessão</h3>
                <form>
                    <label for="session-details">Detalhes da Sessão:</label>
                    <textarea id="session-details" rows="4" style="width: 100%; border-radius: 5px;"></textarea>
                    <button class="btn" type="button">Adicionar Sessão</button>
                </form>
            </div>

            <!-- Cards de Sessões -->
            <div class="card">
                <h3>Sessão 1</h3>
                <p><strong>Anotações:</strong> Paciente apresentou sinais de melhora.</p>
            </div>
            <div class="card">
                <h3>Sessão 2</h3>
                <p><strong>Anotações:</strong> Conversa sobre práticas de mindfulness.</p>
            </div>
        </div>
    </div>

    <footer>
        <img src="src/images/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">
                &copy 2024 Uni Medical
            </span>
            <div class="social-media-buttons">
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-facebook"></i></a>
            </div>
        </div>
    </footer>

    <script>
        function mostrarFormulario() {
            var form = document.getElementById('formAdicionarPaciente');
            form.style.display = 'block';  
        }

        function salvarPaciente() {
            
            var nome = document.getElementById('nome').value;
            var idade = document.getElementById('idade').value;
            var observacoes = document.getElementById('observacoes').value;

            
            var pacientesList = document.getElementById('pacientesList');
            var pacienteDiv = document.createElement('div');
            pacienteDiv.classList.add('card');
            pacienteDiv.innerHTML = `
                <h3>${nome}</h3>
                <p><strong>Idade:</strong> ${idade}</p>
                <p><strong>Observações:</strong> ${observacoes}</p>
            `;
            pacientesList.appendChild(pacienteDiv);

            
            document.getElementById('formPaciente').reset();

            
            document.getElementById('formAdicionarPaciente').style.display = 'none';
        }
    </script>
</body>
</html>
