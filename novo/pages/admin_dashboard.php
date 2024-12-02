<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?> (Admin)</h1>
        <nav>
            <a href="criar_usuario.php">Criar Usuário</a>
            <a href="listar_prontuarios.php">Listar Prontuários</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
</body>
</html>
