<?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'aluno') {
    header('Location: login.php');
    exit;
}

$aluno_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM prontuarios WHERE paciente_id = ?");
$stmt->execute([$aluno_id]);
$prontuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Dashboard do Aluno</h1>
                <nav>
                    <a href="logout.php" class="btn btn-light">Logout</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <h2>Meus Prontuários</h2>
        <div class="mb-3">
            <a href="criar_prontuario.php" class="btn btn-success">Criar Novo Prontuário</a>
        </div>
        <?php if (count($prontuarios) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Número do Prontuário</th>
                            <th>Data de Abertura</th>
                            <th>Escolaridade</th>
                            <th>Ocupação</th>
                            <th>Estagiário</th>
                            <th>Orientador</th>
                            <th>Data e Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prontuarios as $prontuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($prontuario['numero_prontuario']) ?></td>
                                <td><?= htmlspecialchars($prontuario['data_abertura']) ?></td>
                                <td><?= htmlspecialchars($prontuario['escolaridade']) ?></td>
                                <td><?= htmlspecialchars($prontuario['ocupacao']) ?></td>
                                <td><?= htmlspecialchars($prontuario['estagiario']) ?></td>
                                <td><?= htmlspecialchars($prontuario['orientador']) ?></td>
                                <td><?= htmlspecialchars($prontuario['data_hora']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há prontuários cadastrados.</div>
        <?php endif; ?>
    </main>
</body>
</html>
