<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'aluno') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aluno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?> (Aluno)</h1>
        <nav>
            <a href="listar_prontuarios.php">Meus Prontuários</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    <main>
        <h2>Prontuários e Sessões</h2>
        <!-- Aqui poderá haver uma listagem dos prontuários vinculados ao aluno -->
    </main>
</body>
</html>