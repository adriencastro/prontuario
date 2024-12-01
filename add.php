<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'u470795851_trabalho';
$username = 'u470795851_trabalho'; // Ajuste conforme seu ambiente
$password = '#Ewdfh1k7'; // Ajuste conforme seu ambiente


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usuario = 'admin';
    $senha = password_hash('123456', PASSWORD_DEFAULT); // Cria um hash da senha "123456"

    $sql = "INSERT INTO usuarios (username, senha) VALUES (:username, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    echo "Usuário inserido com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}
?>