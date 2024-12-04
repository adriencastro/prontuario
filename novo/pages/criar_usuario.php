<?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'professor')) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $role = ($_SESSION['role'] === 'professor') ? 'aluno' : $_POST['role'];
    $criado_por = $_SESSION['user_id'];

    try {
        // Inserir usuário na tabela `usuarios`
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, senha, role, criado_por) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $senha, $role, $criado_por]);
        $novo_usuario_id = $pdo->lastInsertId();

        // Se o usuário for um aluno, registrá-lo automaticamente na tabela `pacientes`
        if ($role === 'aluno') {
            $stmt_paciente = $pdo->prepare("INSERT INTO pacientes (id, nome_completo, data_nascimento, genero, endereco, telefone, email, contato_emergencia_nome, contato_emergencia_telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_paciente->execute([$novo_usuario_id, $username, '2000-01-01', 'masculino', 'Endereço Padrão', '000000000', 'email@example.com', 'Contato de Emergência', '000000000']);
        }

        $sucesso = "Usuário criado com sucesso.";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $erro = "Erro: Nome de usuário já existe. Por favor, escolha um nome diferente.";
        } else {
            $erro = "Erro ao criar usuário. Por favor, tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Criar Usuário</h1>
                <nav>
                    <a href="<?= ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'professor_dashboard.php') ?>" class="btn btn-light">Voltar</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($sucesso) ?>
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
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="col-md-6">
                <label for="role" class="form-label">Tipo de Usuário:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="professor">Professor</option>
                    <option value="aluno">Aluno</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Criar Usuário</button>
            </div>
        </form>
    </main>
</body>
</html>
