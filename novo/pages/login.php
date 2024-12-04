<?php
session_start();
require_once '../db/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    try {
        // Buscar usuário pelo nome de usuário
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o usuário foi encontrado e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Configurar sessão do usuário
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['username'];
            $_SESSION['role'] = $usuario['role'];

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
            $erro = "Nome de usuário ou senha inválidos.";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao tentar fazer login. Por favor, tente novamente.";
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Login</h2>
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($erro) ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de Usuário:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
