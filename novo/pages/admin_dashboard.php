<?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Obter professores e alunos cadastrados
$stmt_professores = $pdo->query("SELECT * FROM usuarios WHERE role = 'professor'");
$professores = $stmt_professores->fetchAll(PDO::FETCH_ASSOC);

$stmt_alunos = $pdo->query("SELECT * FROM usuarios WHERE role = 'aluno'");
$alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?> (Admin)</h1>
                <nav>
                    <a href="criar_usuario.php" class="btn btn-light">Criar Usuário</a>
                    <a href="criar_prontuario.php" class="btn btn-light">Criar Prontuário</a>
                    <a href="logout.php" class="btn btn-danger">Sair</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <h2>Professores Cadastrados</h2>
        <?php if (count($professores) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nome de Usuário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($professores as $professor): ?>
                            <tr>
                                <td><?= htmlspecialchars($professor['username']) ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?= $professor['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_usuario.php?id=<?= $professor['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há professores cadastrados.</div>
        <?php endif; ?>

        <h2 class="mt-5">Alunos Cadastrados</h2>
        <?php if (count($alunos) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nome de Usuário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= htmlspecialchars($aluno['username']) ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?= $aluno['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_usuario.php?id=<?= $aluno['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há alunos cadastrados.</div>
        <?php endif; ?>
    </main>
</body>
</html>
