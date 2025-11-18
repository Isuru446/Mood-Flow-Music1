<?php
require 'config.php';

$return = $_GET['return'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ' . $return);
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <h1>Login</h1>
  <div style="margin-bottom:12px">
    <a class="btn btn-ghost" href="#" onclick="history.back();return false;">Back</a>
    <a class="btn" href="index.php">Home</a>
  </div>
  <?php if (!empty($error)) echo '<p style="color:#b71c1c">'.htmlspecialchars($error).'</p>'; ?>
  <div class="form-panel">
    <form method="post" action="login.php?return=<?php echo urlencode($return) ?>">
      <div><label>Username: <input type="text" name="username" required></label></div>
      <div style="margin-top:8px"><label>Password: <input type="password" name="password" required></label></div>
      <div class="form-actions"><button class="btn" type="submit">Login</button> <a class="admin-link" href="register.php">Register</a></div>
    </form>
  </div>
</div>
</body>
</html>
