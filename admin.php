<?php
require 'config.php';

// Simple admin authentication (username + password)
if (isset($_POST['username']) && isset($_POST['password'])) {
  $user = trim($_POST['username']);
  $pass = $_POST['password'];
  if ($user === $admin_user && $pass === $admin_password) {
    $_SESSION['is_admin'] = true;
    header('Location: admin.php');
    exit;
  } else {
    $error = 'Incorrect username or password';
  }
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (!empty($_SESSION['is_admin'])) {
    // fetch songs
    $s = $pdo->query("SELECT * FROM songs ORDER BY id DESC");
    $songs = $s->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin - Mood Music</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <h1>Admin - Mood Music</h1>

  <?php if (empty($_SESSION['is_admin'])): ?>
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
    <div class="panel">
      <form method="post" action="admin.php">
        <div class="form-row">
          <div style="flex:1"><label>Username: <input type="text" name="username" required></label></div>
          <div style="flex:1"><label>Password: <input type="password" name="password" required></label></div>
        </div>
        <div class="form-actions"><button class="btn" type="submit">Login</button></div>
      </form>
    </div>
    <p><a href="index.php">Back to user view</a></p>
  <?php else: ?>
    <p><a class="admin-link" href="admin.php?logout=1">Logout</a> | <a class="admin-link" href="index.php">User view</a></p>

    <h2>Add song</h2>
    <div class="form-panel">
      <form method="post" action="add_song.php">
        <div class="form-row">
          <div style="flex:1"><label>Title: <input type="text" name="title" required></label></div>
          <div style="flex:1"><label>Artist: <input type="text" name="artist"></label></div>
        </div>
        <div class="form-row" style="margin-top:10px">
          <div style="flex:1"><label>Mood: <input type="text" name="mood"></label></div>
          <div style="flex:1"><label>Playlist: <input type="text" name="playlist"></label></div>
        </div>
        <div style="margin-top:10px"><label>URL (mp3 link): <input type="text" name="url"></label></div>
        <div class="form-actions"><button class="btn" type="submit">Add Song</button></div>
      </form>
    </div>

    <h2>Existing songs</h2>
    <div class="card">
      <?php if (empty($songs)): ?>
        <p>No songs yet.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Artist</th>
              <th>Mood</th>
              <th>Playlist</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($songs as $song): ?>
            <tr>
              <td><?php echo htmlspecialchars($song['title']) ?></td>
              <td><?php echo htmlspecialchars($song['artist']) ?></td>
              <td><?php echo htmlspecialchars($song['mood']) ?></td>
              <td><?php echo htmlspecialchars($song['playlist']) ?></td>
              <td class="text-right">
                <a href="edit_song.php?id=<?php echo $song['id'] ?>">Edit</a>
                &nbsp;|&nbsp;
                <a href="delete_song.php?id=<?php echo $song['id'] ?>" onclick="return confirm('Delete this song?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

  <?php endif; ?>
</div>
</body>
</html>
