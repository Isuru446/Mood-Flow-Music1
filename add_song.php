<?php
require 'config.php';
if (empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $mood = $_POST['mood'] ?? '';
    $playlist = $_POST['playlist'] ?? '';
    $url = $_POST['url'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO songs (title, artist, mood, playlist, url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $artist, $mood, $playlist, $url]);
}
header('Location: admin.php');
exit;
