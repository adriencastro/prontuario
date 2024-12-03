<?php
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

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);

header('Location: admin_dashboard.php');
exit;
?>
