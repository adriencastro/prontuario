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
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/professor_dashboard.js" defer></script>
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
        <?php if (count($alunos) > 0): ?>
            <ul>
                <?php foreach ($alunos as $aluno): ?>
                    <li><?= htmlspecialchars($aluno['username']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Não há alunos vinculados a este professor.</p>
        <?php endif; ?>
    </main>
</body>
</html>
    </main>
</body>
</html>