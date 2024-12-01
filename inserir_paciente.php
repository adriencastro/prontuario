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
        $nome = $_POST['nome'];
        $data_abertura = $_POST['data_abertura'];
        $observacao = $_POST['observacao'];

        $sql = "INSERT INTO paciente (nome, data_abertura, observacao) VALUES (:nome, :data_abertura, :observacao)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data_abertura', $data_abertura);
        $stmt->bindParam(':observacao', $observacao);

        if ($stmt->execute()) {
            echo "Registro inserido com sucesso! atualize a página";
        } else {
            echo "Erro ao inserir registro.";
        }
    }
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>