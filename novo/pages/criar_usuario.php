<?php
session_start();
require_once '../db/db_config.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'professor')) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = md5($_POST['senha']);
    $role = $_POST['role'];

    if ($_SESSION['role'] === 'professor' && $role !== 'aluno') {
        die("Professores só podem criar contas para alunos.");
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (username, senha, role, criado_por) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $senha, $role, $_SESSION['user_id']]);

    echo "Usuário criado com sucesso.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <form method="POST">
        <h2>Criar Usuário</h2>
        <label>Usuário:</label>
        <input type="text" name="username" required>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <label>Papel:</label>
        <select name="role" required>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <option value="professor">Professor</option>
            <?php endif; ?>
            <option value="aluno">Aluno</option>
        </select>
        <button type="submit">Criar</button>
    </form>
</body>
</html>
