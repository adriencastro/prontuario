<?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'professor') {
    header('Location: login.php');
    exit;
}

// Obter alunos vinculados ao professor
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE criado_por = ? AND role = 'aluno'");
$stmt->execute([$user_id]);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/professor_dashboard.js" defer></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?> (Professor)</h1>
                <nav>
                    <a href="criar_usuario.php" class="btn btn-light">Criar Aluno</a>
                    <a href="listar_prontuarios.php" class="btn btn-light">Listar Prontuários dos Alunos</a>
                    <a href="criar_prontuario.php" class="btn btn-light">Criar Prontuário</a>
                    <a href="logout.php" class="btn btn-danger">Sair</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <h2>Alunos Vinculados</h2>
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
                                    <a href="editar_aluno.php?id=<?= $aluno['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_aluno.php?id=<?= $aluno['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há alunos vinculados a este professor.</div>
        <?php endif; ?>
    </main>
</body>
</html>