<?php
// Exemplo de como criar usuários utilizando password_hash no PHP
require_once '../db/db_config.php';

// Criando o usuário admin
$senhaAdmin = password_hash('admin_senha', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (username, senha, role) VALUES (?, ?, ?)");
$stmt->execute(['admin', $senhaAdmin, 'admin']);

// Criando o usuário professor
$senhaProfessor = password_hash('professor_senha', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (username, senha, role, criado_por) VALUES (?, ?, ?, ?)");
$stmt->execute(['professor1', $senhaProfessor, 'professor', 1]);

// Criando os alunos
$senhaAluno = password_hash('aluno_senha', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (username, senha, role, criado_por) VALUES (?, ?, ?, ?)");
$stmt->execute(['aluno1', $senhaAluno, 'aluno', 2]);

$stmt->execute(['aluno2', $senhaAluno, 'aluno', 2]);
?>
