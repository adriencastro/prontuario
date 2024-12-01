<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'u470795851_trabalho';
$username = 'u470795851_trabalho'; // Ajuste conforme seu ambiente
$password = '#Ewdfh1k7'; // Ajuste conforme seu ambiente

header('Content-Type: application/json; charset=utf-8'); // Define o tipo de resposta como JSON

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar os registros
    $sql = "SELECT id, nome, data, observacao FROM aluno ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $aluno = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os registros em formato JSON
    echo json_encode($aluno);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}