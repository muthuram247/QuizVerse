<?php
require __DIR__ . '/db.php';
try {
  $g = google_user_from_bearer();
  $pdo = db();
  $stmt = $pdo->prepare('INSERT INTO users (google_sub, email, display_name, avatar_url) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE email=VALUES(email), display_name=VALUES(display_name), avatar_url=VALUES(avatar_url)');
  $stmt->execute([$g['sub'], $g['email'], $g['name'] ?? 'QuizVerse Player', $g['picture'] ?? null]);
  $stmt = $pdo->prepare('SELECT id, display_name, email FROM users WHERE google_sub = ?');
  $stmt->execute([$g['sub']]);
  json_out(200, ['ok'=>true,'user'=>$stmt->fetch()]);
} catch (Throwable $e) {
  error_log((string)$e);
  json_out(500, ['ok'=>false,'error'=>'Could not complete sign-in']);
}
