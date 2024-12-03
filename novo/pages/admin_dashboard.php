?php
session_start();
require_once '../db/db_config.php';
if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : $usuario['senha'];
        $role = $_POST['role'];

        $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, senha = ?, role = ? WHERE id = ?");
        $stmt->execute([$username, $senha, $role, $id]);

        echo "Usuário atualizado com sucesso.";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $erro = "Erro: Nome de usuário já existe. Por favor, escolha um nome diferente.";
        } else {
            $erro = "Erro ao atualizar usuário. Por favor, tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Editar Usuário</h1>
                <nav>
                    <a href="admin_dashboard.php" class="btn btn-light">Voltar</a>
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
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="username" class="form-label">Nome de Usuário:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="senha" class="form-label">Senha (deixe em branco para manter a atual):</label>
                <input type="password" class="form-control" id="senha" name="senha">
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Tipo de Usuário:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="professor" <?= $usuario['role'] === 'professor' ? 'selected' : '' ?>>Professor</option>
                    <option value="aluno" <?= $usuario['role'] === 'aluno' ? 'selected' : '' ?>>Aluno</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
            </div>
        </form>
    </main>
</body>
</html>