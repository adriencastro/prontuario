<?php
session_start();
require_once '../db/db_config.php';

if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Carregar os dados dos usuários
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Admin Dashboard</h1>
                <nav>
                    <a href="logout.php" class="btn btn-light">Logout</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <h2>Gerenciar Usuários</h2>
        <div class="mb-3">
            <a href="criar_usuario.php" class="btn btn-success">Criar Novo Usuário</a>
        </div>
        <?php if (count($usuarios) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome de Usuário</th>
                            <th>Tipo de Usuário</th>
                            <th>Criado Por</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id']) ?></td>
                                <td><?= htmlspecialchars($usuario['username']) ?></td>
                                <td><?= htmlspecialchars($usuario['role']) ?></td>
                                <td><?= htmlspecialchars($usuario['criado_por']) ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há usuários cadastrados.</div>
        <?php endif; ?>
    </main>
</body>
</html>
