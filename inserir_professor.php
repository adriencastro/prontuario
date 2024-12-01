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
        $professornome = $_POST['professornome'];
        $email = $_POST['email'];
        $especialidade = $_POST['especialidade'];

        $sql = "INSERT INTO professor (professornome, email, especialidade) VALUES (:professornome, :email, :especialidade)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':professornome', $professornome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':especialidade', $especialidade);

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