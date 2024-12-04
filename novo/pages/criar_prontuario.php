<?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || ($_SESSION['role'] !== 'aluno' && $_SESSION['role'] !== 'professor' && $_SESSION['role'] !== 'admin')) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_prontuario = $_POST['numero_prontuario'];
    $data_abertura = $_POST['data_abertura'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato_emergencia_nome = $_POST['contato_emergencia_nome'];
    $contato_emergencia_telefone = $_POST['contato_emergencia_telefone'];
    $escolaridade = $_POST['escolaridade'];
    $ocupacao = $_POST['ocupacao'];
    $necessidade_especial = isset($_POST['necessidade_especial']) ? implode(", ", $_POST['necessidade_especial']) : 'Nenhuma';
    $estagiario = $_POST['estagiario'];
    $orientador = $_POST['orientador'];
    $data_hora = $_POST['data_hora'];
    $assinatura_responsavel = $_POST['assinatura_responsavel'];
    $assinatura_professor = $_POST['assinatura_professor'];
    $criado_por = $_SESSION['user_id'];
    $paciente_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO prontuarios (numero_prontuario, data_abertura, data_nascimento, genero, endereco, telefone, email, contato_emergencia_nome, contato_emergencia_telefone, escolaridade, ocupacao, necessidade_especial, estagiario, orientador, data_hora, assinatura_responsavel, assinatura_professor, criado_por, paciente_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$numero_prontuario, $data_abertura, $data_nascimento, $genero, $endereco, $telefone, $email, $contato_emergencia_nome, $contato_emergencia_telefone, $escolaridade, $ocupacao, $necessidade_especial, $estagiario, $orientador, $data_hora, $assinatura_responsavel, $assinatura_professor, $criado_por, $paciente_id]);
        $sucesso = "Prontuário criado com sucesso.";
    } catch (PDOException $e) {
        $erro = "Erro ao criar prontuário: " . $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Prontuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Criar Prontuário</h1>
                <nav>
                    <a href="aluno_dashboard.php" class="btn btn-light">Voltar</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($sucesso) ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="numero_prontuario" class="form-label">Número do Prontuário:</label>
                <input type="text" class="form-control" id="numero_prontuario" name="numero_prontuario" required>
            </div>
            <div class="col-md-6">
                <label for="data_abertura" class="form-label">Data de Abertura:</label>
                <input type="date" class="form-control" id="data_abertura" name="data_abertura" required>
            </div>
            <div class="col-md-6">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="col-md-6">
                <label for="genero" class="form-label">Gênero:</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="endereco" class="form-label">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="contato_emergencia_nome" class="form-label">Nome do Contato de Emergência:</label>
                <input type="text" class="form-control" id="contato_emergencia_nome" name="contato_emergencia_nome" required>
            </div>
            <div class="col-md-6">
                <label for="contato_emergencia_telefone" class="form-label">Telefone do Contato de Emergência:</label>
                <input type="text" class="form-control" id="contato_emergencia_telefone" name="contato_emergencia_telefone" required>
            </div>
            <div class="col-md-6">
                <label for="escolaridade" class="form-label">Escolaridade:</label>
                <input type="text" class="form-control" id="escolaridade" name="escolaridade" required>
            </div>
            <div class="col-md-6">
                <label for="ocupacao" class="form-label">Ocupação:</label>
                <input type="text" class="form-control" id="ocupacao" name="ocupacao" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Necessidade Especial:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="cognitiva" name="necessidade_especial[]" value="cognitiva">
                    <label class="form-check-label" for="cognitiva">Cognitiva</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="locomocao" name="necessidade_especial[]" value="locomoção">
                    <label class="form-check-label" for="locomocao">Locomoção</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="visao" name="necessidade_especial[]" value="visão">
                    <label class="form-check-label" for="visao">Visão</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="audicao" name="necessidade_especial[]" value="audição">
                    <label class="form-check-label" for="audicao">Audição</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="outros" name="necessidade_especial[]" value="outros">
                    <label class="form-check-label" for="outros">Outros</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="estagiario" class="form-label">Estagiário:</label>
                <input type="text" class="form-control" id="estagiario" name="estagiario" required>
            </div>
            <div class="col-md-6">
                <label for="orientador" class="form-label">Orientador:</label>
                <input type="text" class="form-control" id="orientador" name="orientador" required>
            </div>
            <div class="col-md-6">
                <label for="data_hora" class="form-label">Data e Hora:</label>
                <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
            </div>
            <div class="col-md-6">
                <label for="assinatura_responsavel" class="form-label">Assinatura do Responsável:</label>
                <input type="text" class="form-control" id="assinatura_responsavel" name="assinatura_responsavel" required>
            </div>
            <div class="col-md-6">
                <label for="assinatura_professor" class="form-label">Assinatura do Professor:</label>
                <input type="text" class="form-control" id="assinatura_professor" name="assinatura_professor" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Criar Prontuário</button>
            </div>
        </form>
    </main>
</body>
</html>
