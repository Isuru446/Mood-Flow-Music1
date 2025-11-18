<?php
require 'config.php';
if (empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $mood = $_POST['mood'] ?? '';
    $playlist = $_POST['playlist'] ?? '';
    $url = $_POST['url'] ?? '';

    $stmt = $pdo->prepare("UPDATE songs SET title = ?, artist = ?, mood = ?, playlist = ?, url = ? WHERE id = ?");
    $stmt->execute([$title, $artist, $mood, $playlist, $url, $id]);
    header('Location: admin.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM songs WHERE id = ?");
$stmt->execute([$id]);
$song = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$song) {
    header('Location: admin.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Song</title>
  <link rel="stylesheet" href="styles.css">
  <style>.container{max-width:900px;margin:30px auto;padding:20px}</style>
</head>
<body>
<div class="container">
  <h1>Edit Song</h1>
  <div style="margin-bottom:12px">
    <a class="btn btn-ghost" href="#" onclick="history.back();return false;">Back</a>
    <a class="btn" href="index.php">Home</a>
    &nbsp;&nbsp;<a class="admin-link" href="admin.php">Admin</a>
  </div>
  <div class="form-panel">
    <form method="post" action="edit_song.php?id=<?php echo $song['id'] ?>">
      <div class="form-row">
        <div style="flex:1"><label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($song['title']) ?>" required></label></div>
        <div style="flex:1"><label>Artist: <input type="text" name="artist" value="<?php echo htmlspecialchars($song['artist']) ?>"></label></div>
      </div>
      <div class="form-row" style="margin-top:8px">
        <div style="flex:1"><label>Mood: <input type="text" name="mood" value="<?php echo htmlspecialchars($song['mood']) ?>"></label></div>
        <div style="flex:1"><label>Playlist: <input type="text" name="playlist" value="<?php echo htmlspecialchars($song['playlist']) ?>"></label></div>
      </div>
      <div style="margin-top:8px"><label>URL: <input type="text" name="url" value="<?php echo htmlspecialchars($song['url']) ?>"></label></div>
      <div class="form-actions"><button class="btn" type="submit">Save</button> <a class="admin-link" href="admin.php">Cancel</a></div>
    </form>
  </div>
</div>
</body>
</html>

