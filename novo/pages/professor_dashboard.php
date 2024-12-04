<?php
session_start();
require_once '../db/db_config.php';

if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'professor') {
    header('Location: login.php');
    exit;
}

// Carregar alunos do professor
$professor_id = $_SESSION['user_id'];
$stmt_alunos = $pdo->prepare("SELECT * FROM usuarios WHERE criado_por = ?");
$stmt_alunos->execute([$professor_id]);
$alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

// Carregar prontuários dos alunos criados por este professor
$stmt_prontuarios = $pdo->prepare("SELECT p.*, a.username AS aluno_nome FROM prontuarios p JOIN usuarios a ON p.paciente_id = a.id WHERE a.criado_por = ?");
$stmt_prontuarios->execute([$professor_id]);
$prontuarios = $stmt_prontuarios->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Professor Dashboard</h1>
                <nav>
                    <a href="logout.php" class="btn btn-light">Logout</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <h2>Gerenciar Alunos</h2>
        <div class="mb-3">
            <a href="criar_usuario.php" class="btn btn-success">Criar Novo Aluno</a>
        </div>
        <?php if (count($alunos) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome de Usuário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= htmlspecialchars($aluno['id']) ?></td>
                                <td><?= htmlspecialchars($aluno['username']) ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?= $aluno['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_usuario.php?id=<?= $aluno['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há alunos cadastrados.</div>
        <?php endif; ?>

        <h2 class="mt-5">Prontuários dos Alunos</h2>
        <?php if (count($prontuarios) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Número do Prontuário</th>
                            <th>Aluno</th>
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
                                <td><?= htmlspecialchars($prontuario['aluno_nome']) ?></td>
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
            <div class="alert alert-warning">Não há prontuários cadastrados pelos alunos.</div>
        <?php endif; ?>
    </main>
</body>
</html>
