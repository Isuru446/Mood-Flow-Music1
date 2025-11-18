<?php
require 'config.php';
if (empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM songs WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: admin.php');
exit;

