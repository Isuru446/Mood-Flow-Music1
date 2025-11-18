<?php
require 'config.php';

$stmt = $pdo->query("SELECT DISTINCT mood FROM songs WHERE mood <> '' ORDER BY mood");
$moods = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mood Music</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="hero panel" style="padding:28px 24px 36px;">
    <h1 style="font-size:2.2rem;margin:0 0 8px 0">Welcome to MoodFlow Music! ♪</h1>
    <p style="margin:0 0 16px;color:var(--muted)">Discover the perfect scoodtrack for every moment. Our site ihleby find matches the curent mood. Simply tell us how you're feeling, and we curate flo playlist just for you.</p>
    <div style="margin:18px 0">
      <a class="btn" href="mood_music.php">Find My Mood Music</a>
    </div>
    <p style="margin-top:8px;color:var(--muted)">Or, jump right in and select to mood:</p>
  </div>

  <div class="mood-list panel" style="margin-top:16px;padding:16px">
    <div class="top-row">
      <p class="muted">Choose a mood to see songs. You will be asked to login if not already.</p>
      <div>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <span class="muted">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'user') ?></span>
          &nbsp;|&nbsp;<a class="admin-link" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="admin-link" href="login.php">Login</a>
          &nbsp;|&nbsp;
          <a class="admin-link" href="register.php">Register</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="mood-grid">
      <?php foreach ($moods as $m): ?>
        <a class="mood-tile mood-tile--dark card--clickable" href="songs.php?mood=<?php echo urlencode($m) ?>">
          <div class="info">
            <strong><?php echo htmlspecialchars($m) ?></strong>
            <div class="meta">Browse songs</div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:18px;color:var(--muted)"><strong>Your Recomendations Will Appear Here:</strong></div>
  </div>

  <hr>
  <p><a href="admin.php">Admin: add / edit songs</a></p>
</div>
</body>
</html>

