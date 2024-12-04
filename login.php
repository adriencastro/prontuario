<?php
session_start();
require_once '../db/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Se a senha estiver correta, iniciar sessão
        $_SESSION['usuario'] = $usuario['username'];
        $_SESSION['role'] = $usuario['role'];
        $_SESSION['user_id'] = $usuario['id'];

        // Redirecionar para o painel apropriado
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <h1>Login</h1>
        </div>
    </header>
    <main class="container mt-4">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="username" class="form-label">Nome de Usuário:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="col-md-6">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </main>
</body>
</html>
