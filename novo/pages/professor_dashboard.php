<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'professor') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?> (Professor)</h1>
        <nav>
            <a href="criar_usuario.php">Criar Aluno</a>
            <a href="listar_prontuarios.php">Listar Prontuários dos Alunos</a>
            <a href="criar_prontuario.php">Criar Prontuário</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    <main>
        <h2>Alunos Vinculados</h2>
        <!-- Aqui poderá haver uma listagem dos alunos criados pelo professor -->
    </main>
</body>
</html>