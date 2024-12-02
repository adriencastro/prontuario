<?php
session_start();

if (isset($_SESSION['usuario'])) {
    // Redirecionar para o dashboard apropriado
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_dashboard.php');
    } elseif ($_SESSION['role'] === 'professor') {
        header('Location: professor_dashboard.php');
    } elseif ($_SESSION['role'] === 'aluno') {
        header('Location: aluno_dashboard.php');
    }
    exit;
}

require_once '../db/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = md5($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? AND senha = ?");
    $stmt->execute([$username, $senha]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario['username'];
        $_SESSION['role'] = $usuario['role'];
        $_SESSION['user_id'] = $usuario['id'];

        // Redirecionar para o dashboard apropriado
        if ($usuario['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } elseif ($usuario['role'] === 'professor') {
            header('Location: professor_dashboard.php');
        } elseif ($usuario['role'] === 'aluno') {
            header('Location: aluno_dashboard.php');
        }
        exit;
    } else {
        $erro = "Usuário ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <?php if (isset($erro)): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Usuário:</label>
            <input type="text" name="username" required>
            <label>Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>