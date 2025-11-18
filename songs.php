<?php
require 'config.php';

$mood = $_GET['mood'] ?? null;
if (!$mood) {
    header('Location: index.php');
    exit;
}

// Require login
if (empty($_SESSION['user_id'])) {
    $return = 'songs.php?mood=' . urlencode($mood);
    header('Location: login.php?return=' . urlencode($return));
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM songs WHERE mood = ? ORDER BY id DESC");
$stmt->execute([$mood]);
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Songs — <?php echo htmlspecialchars($mood) ?></title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="top-row">
    <h1>Songs: <?php echo htmlspecialchars($mood) ?></h1>
    <div>
      <a class="btn btn-ghost" href="#" onclick="history.back();return false;">Back</a>
      <a class="btn" href="index.php">Home</a>
      &nbsp;&nbsp;
      <span class="muted">Logged in as <?php echo htmlspecialchars($_SESSION['username'] ?? '') ?></span>
      &nbsp;|&nbsp;<a class="admin-link" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="panel">
    <?php if (empty($songs)): ?>
      <p>No songs available for this mood.</p>
    <?php else: ?>
      <?php foreach ($songs as $song): ?>
        <div class="card card--clickable song">
          <div class="info">
            <strong><?php echo htmlspecialchars($song['title']) ?></strong>
            <div class="meta"><?php echo htmlspecialchars($song['artist']) ?> — Playlist: <?php echo htmlspecialchars($song['playlist']) ?></div>
            <?php if (!empty($song['url'])): ?>
              <audio controls>
                <source src="<?php echo htmlspecialchars($song['url']) ?>">
              </audio>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
