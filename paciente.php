<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/styles.css">
    <title>Area do Paciente</title>
</head>
<body id="footer-paciente">
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-user" id="nav_logo"> Área do Aluno</i>
            <ul id="nav_list">
                <li class="nav-item active"><a href="#home">Início</a></li>
                <li class="nav-item"><a href="#profile">Perfil</a></li>
                <li class="nav-item"><a href="#appointment">Agendamento</a></li>
            </ul>
            <button id="logoutButton" class="btn-default">Logout</button>
            <button id="mobile_btn"><i class="fa-solid fa-bars"></i></button>
        </nav>
    </header>

    <!-- Paciente -->
    <div class="container">
        <h1>Cadastro e Agendamento de Consultas</h1>

        
        <form id="paciente-form">
            <h2>Informações Pessoais</h2>
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required min="1" max="120">

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00">

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required placeholder="(00) 00000-0000">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="exemplo@dominio.com">

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="motivo">Motivo da Consulta:</label>
            <textarea id="motivo" name="motivo" required placeholder="Descreva brevemente o motivo da sua consulta"></textarea>

            <h2>Agendamento de Consulta</h2>
            <label for="data-consulta">Data:</label>
            <input type="date" id="data-consulta" name="data-consulta" required>

            <label for="horario">Horário:</label>
            <input type="time" id="horario" name="horario" required>

            <label for="preferencia">Preferência de Atendimento:</label>
            <select id="preferencia" name="preferencia">
                <option value="presencial">Presencial</option>
                <option value="online">Online</option>
            </select>

            <button type="submit">Agendar Consulta</button>
        </form>
    </div>

    <footer>
        <img src="src/images/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">&copy 2024</span>
            <div class="social-media-buttons">
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-facebook"></i></a>
            </div>
        </div>
    </footer>

    <script src="src/javascript/script.js"></script>

    
    <script>
        document.getElementById('paciente-form').addEventListener('submit', function(e) {
            e.preventDefault();

            
            const nome = document.getElementById('nome').value;
            const idade = document.getElementById('idade').value;
            const cpf = document.getElementById('cpf').value;
            const telefone = document.getElementById('telefone').value;
            const email = document.getElementById('email').value;
            const endereco = document.getElementById('endereco').value;
            const motivo = document.getElementById('motivo').value;
            const dataConsulta = document.getElementById('data-consulta').value;
            const horario = document.getElementById('horario').value;
            const preferencia = document.getElementById('preferencia').value;

            alert(`Consulta agendada!\n\nPaciente: ${nome}\nData: ${dataConsulta}\nHorário: ${horario}\nPreferência: ${preferencia}`);
            
            
            document.getElementById('paciente-form').reset();
        });
    </script>
</body id="footer-paciente">
</html>
