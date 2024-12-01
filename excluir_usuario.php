<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'u470795851_trabalho';
$username = 'u470795851_trabalho'; // Ajuste conforme seu ambiente
$password = '#Ewdfh1k7'; // Ajuste conforme seu ambiente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Obtém o ID do usuário a ser excluído

    try {
        // Conexão com o banco de dados
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comando SQL para excluir o usuário
        $sql = "DELETE FROM paciente WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecionar de volta para a página administrativa
        header('Location: admin.php');
        exit;

    } catch (PDOException $e) {
        echo "Erro ao excluir o usuário: " . $e->getMessage();
    }
} else {
    // Redirecionar caso o acesso não seja via POST
    header('Location: admin.php');
    exit;
}
