<?php
session_start();
require_once '../db/db_config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role === 'admin') {
    $stmt = $pdo->query("SELECT prontuarios.*, pacientes.nome AS paciente_nome FROM prontuarios JOIN pacientes ON prontuarios.paciente_id = pacientes.id");
} elseif ($role === 'professor') {
    $stmt = $pdo->prepare("SELECT prontuarios.*, pacientes.nome AS paciente_nome FROM prontuarios JOIN pacientes ON prontuarios.paciente_id = pacientes.id WHERE prontuarios.criado_por = ? OR pacientes.id IN (SELECT id FROM pacientes WHERE criado_por = ?)");
    $stmt->execute([$user_id, $user_id]);
} else {
    $stmt = $pdo->prepare("SELECT prontuarios.*, pacientes.nome AS paciente_nome FROM prontuarios JOIN pacientes ON prontuarios.paciente_id = pacientes.id WHERE prontuarios.paciente_id IN (SELECT id FROM pacientes WHERE criado_por = ?)");
    $stmt->execute([$user_id]);
}

$prontuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Prontuários</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/listar_prontuarios.js" defer></script>
</head>
<body>
    <header>
        <h1>Listar Prontuários</h1>
        <nav>
            <a href=" . ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : ($_SESSION['role'] === 'professor' ? 'professor_dashboard.php' : 'aluno_dashboard.php')) . ">Voltar ao Dashboard</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Criado Em</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($prontuarios) > 0): ?>
                    <?php foreach ($prontuarios as $prontuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($prontuario['id']) ?></td>
                            <td><?= htmlspecialchars($prontuario['paciente_nome']) ?></td>
                            <td><?= htmlspecialchars($prontuario['titulo']) ?></td>
                            <td><?= htmlspecialchars($prontuario['descricao']) ?></td>
                            <td><?= htmlspecialchars($prontuario['criado_em']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum prontuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>