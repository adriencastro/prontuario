<?php
session_start();
require_once '../db/db_config.php';

// Verificar se o usuário está logado e tem o papel de professor
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'professor') {
    header('Location: login.php');
    exit;
}

// Verificar se o ID do prontuário foi passado
if (!isset($_GET['id'])) {
    header('Location: professor_dashboard.php');
    exit;
}

$prontuario_id = $_GET['id'];

// Buscar prontuário do aluno criado pelo professor logado
try {
    $professor_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("
        SELECT p.*, a.username AS aluno_nome 
        FROM prontuarios p 
        JOIN usuarios a ON p.paciente_id = a.id 
        WHERE p.id = ? AND a.criado_por = ?
    ");
    $stmt->execute([$prontuario_id, $professor_id]);
    $prontuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o prontuário existe e pertence a um aluno criado pelo professor logado
    if (!$prontuario) {
        header('Location: professor_dashboard.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar prontuário: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Prontuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Detalhes do Prontuário</h1>
                <nav>
                    <a href="professor_dashboard.php" class="btn btn-light">Voltar</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Número do Prontuário: <?= htmlspecialchars($prontuario['numero_prontuario']) ?></h5>
                <p class="card-text"><strong>Aluno:</strong> <?= htmlspecialchars($prontuario['aluno_nome']) ?></p>
                <p class="card-text"><strong>Data de Abertura:</strong> <?= htmlspecialchars($prontuario['data_abertura']) ?></p>
                <p class="card-text"><strong>Data de Nascimento:</strong> <?= htmlspecialchars($prontuario['data_nascimento']) ?></p>
                <p class="card-text"><strong>Gênero:</strong> <?= htmlspecialchars($prontuario['genero']) ?></p>
                <p class="card-text"><strong>Endereço:</strong> <?= htmlspecialchars($prontuario['endereco']) ?></p>
                <p class="card-text"><strong>Telefone:</strong> <?= htmlspecialchars($prontuario['telefone']) ?></p>
                <p class="card-text"><strong>E-mail:</strong> <?= htmlspecialchars($prontuario['email']) ?></p>
                <p class="card-text"><strong>Contato de Emergência (Nome):</strong> <?= htmlspecialchars($prontuario['contato_emergencia_nome']) ?></p>
                <p class="card-text"><strong>Contato de Emergência (Telefone):</strong> <?= htmlspecialchars($prontuario['contato_emergencia_telefone']) ?></p>
                <p class="card-text"><strong>Escolaridade:</strong> <?= htmlspecialchars($prontuario['escolaridade']) ?></p>
                <p class="card-text"><strong>Ocupação:</strong> <?= htmlspecialchars($prontuario['ocupacao']) ?></p>
                <p class="card-text"><strong>Necessidade Especial:</strong> <?= htmlspecialchars($prontuario['necessidade_especial']) ?></p>
                <p class="card-text"><strong>Estagiário:</strong> <?= htmlspecialchars($prontuario['estagiario']) ?></p>
                <p class="card-text"><strong>Orientador:</strong> <?= htmlspecialchars($prontuario['orientador']) ?></p>
                <p class="card-text"><strong>Data e Hora:</strong> <?= htmlspecialchars($prontuario['data_hora']) ?></p>
                <p class="card-text"><strong>Assinatura do Responsável:</strong> <?= htmlspecialchars($prontuario['assinatura_responsavel']) ?></p>
                <p class="card-text"><strong>Assinatura do Professor:</strong> <?= htmlspecialchars($prontuario['assinatura_professor']) ?></p>
            </div>
        </div>
    </main>
</body>
</html>
