<?php
session_start();
require_once '../db/db_config.php';

// Verificar se o usuário está logado e tem o papel adequado
if (!isset($_SESSION['usuario']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'professor' && $_SESSION['role'] !== 'aluno')) {
    header('Location: login.php');
    exit;
}

// Ajustar consulta para listar prontuários e incluir o nome do paciente corretamente
$stmt = $pdo->query("
    SELECT prontuarios.*, pacientes.nome_completo AS paciente_nome
    FROM prontuarios
    JOIN pacientes ON prontuarios.paciente_id = pacientes.id
");
$prontuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Prontuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Listar Prontuários</h1>
                <nav>
                    <a href="<?= ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : ($_SESSION['role'] === 'professor' ? 'professor_dashboard.php' : 'aluno_dashboard.php')) ?>" class="btn btn-light">Voltar</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <?php if (count($prontuarios) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Número do Prontuário</th>
                            <th>Paciente</th>
                            <th>Data de Abertura</th>
                            <th>Escolaridade</th>
                            <th>Ocupação</th>
                            <th>Estagiário</th>
                            <th>Orientador</th>
                            <th>Data e Hora</th>
                            <th>Assinatura do Responsável</th>
                            <th>Assinatura do Professor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prontuarios as $prontuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($prontuario['numero_prontuario']) ?></td>
                                <td><?= htmlspecialchars($prontuario['paciente_nome']) ?></td>
                                <td><?= htmlspecialchars($prontuario['data_abertura']) ?></td>
                                <td><?= htmlspecialchars($prontuario['escolaridade']) ?></td>
                                <td><?= htmlspecialchars($prontuario['ocupacao']) ?></td>
                                <td><?= htmlspecialchars($prontuario['estagiario']) ?></td>
                                <td><?= htmlspecialchars($prontuario['orientador']) ?></td>
                                <td><?= htmlspecialchars($prontuario['data_hora']) ?></td>
                                <td><?= htmlspecialchars($prontuario['assinatura_responsavel']) ?></td>
                                <td><?= htmlspecialchars($prontuario['assinatura_professor']) ?></td>
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
