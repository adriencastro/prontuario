<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'u470795851_trabalho';
$username = 'u470795851_trabalho'; // Ajuste conforme seu ambiente
$password = '#Ewdfh1k7'; // Ajuste conforme seu ambiente

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $alunonome = $_POST['nome'];
        $email = $_POST['email'];
        $turma = $_POST['turma'];

        $sql = "INSERT INTO aluno (nome, email, turma) VALUES (:nome, :email, :turma)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':turma', $turma);

        if ($stmt->execute()) {
            echo "Registro inserido com sucesso!";
        } else {
            echo "Erro ao inserir registro.";
        }
    }
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>