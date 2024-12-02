<?php
session_start();
require_once '../db/db_config.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'professor')) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = $_POST['paciente_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $criado_por = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO prontuarios (paciente_id, criado_por, titulo, descricao) VALUES (?, ?, ?, ?)");
    $stmt->execute([$paciente_id, $criado_por, $titulo, $descricao]);

    $mensagem = "Prontuário criado com sucesso.";
}

// Obter pacientes para selecionar ao criar o prontuário
$stmt = $pdo->query("SELECT * FROM pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Prontuário</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/criar_prontuario.js" defer></script>
</head>
<body>
    <header>
        <h1>Criar Prontuário</h1>
        <nav>
            <a href="<?= ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'professor_dashboard.php') ?>">Voltar ao Dashboard</a>
        </nav>
    </header>
    <main>
        <?php if (isset($mensagem)): ?>
            <p class="sucesso"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Paciente:</label>
            <select name="paciente_id" required>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id'] ?>">
                        <?= htmlspecialchars($paciente['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Título:</label>
            <input type="text" name="titulo" required>
            <label>Descrição:</label>
            <textarea name="descricao" required></textarea>
            <button type="submit">Criar Prontuário</button>
        </form>
    </main>
</body>
</html>
