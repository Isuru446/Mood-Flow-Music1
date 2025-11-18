<?php
require 'config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Find My Mood Music</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="top-row">
    <h1>Find My Mood Music</h1>
    <div>
      <a class="btn btn-ghost" href="#" onclick="history.back();return false;">Back</a>
      <a class="btn" href="index.php">Home</a>
    </div>
  </div>

  <div class="panel" style="margin-top:18px">
    <h2>This feature is still devoloping</h2>
    <p class="muted">We're working on a short questionnaire and smarter matching to recommend music based on how you're feeling. For now you can select a mood from the homepage to browse curated lists.</p>
    <p style="margin-top:12px"><a class="btn" href="index.php">Back to home</a></p>
  </div>
</div>
</body>
</html>
