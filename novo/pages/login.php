<?php
session_start();
require_once '../db/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username AND senha = :senha");
    $stmt->execute(['username' => $username, 'senha' => $senha]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['usuario'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        switch ($user['role']) {
            case 'admin':
                header('Location: admin_dashboard.php');
                break;
            case 'professor':
                header('Location: professor_dashboard.php');
                break;
            case 'aluno':
                header('Location: aluno_dashboard.php');
                break;
        }
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
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
    <div class="login-container">
        <form action="" method="POST">
            <h1>Login</h1>
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
            <?php if (isset($erro)): ?>
                <p class="error"><?= $erro ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
