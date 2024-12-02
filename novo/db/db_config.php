<?php
$host = 'localhost';
$dbname = 'u470795851_medical';
$username = 'u470795851_medical';  // Ajuste conforme seu ambiente
$password = '#Ewdfh1k71206';      // Ajuste conforme seu ambiente

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>