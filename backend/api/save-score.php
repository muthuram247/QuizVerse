<?php
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_out(405, ['ok'=>false,'error'=>'Use POST']);
try {
  $g = google_user_from_bearer();
  $data = read_json();
  $score = filter_var($data['score'] ?? null, FILTER_VALIDATE_INT);
  $correct = filter_var($data['correct_count'] ?? null, FILTER_VALIDATE_INT);
  $total = filter_var($data['total_count'] ?? null, FILTER_VALIDATE_INT);
  $category = $data['category'] ?? 'mixed';
  if ($score === false || $score < 0 || $score > 100000 || $correct === false || $total === false || $total < 1 || $total > 100 || $correct < 0 || $correct > $total || !in_array($category, ['mixed','tech'], true)) {
    json_out(422, ['ok'=>false,'error'=>'Invalid score details']);
  }
  $pdo = db();
  $stmt = $pdo->prepare('SELECT id FROM users WHERE google_sub = ?');
  $stmt->execute([$g['sub']]);
  $user = $stmt->fetch();
  if (!$user) json_out(401, ['ok'=>false,'error'=>'Sign in first']);
  $stmt = $pdo->prepare('INSERT INTO scores (user_id, score, correct_count, total_count, category) VALUES (?, ?, ?, ?, ?)');
  $stmt->execute([$user['id'], $score, $correct, $total, $category]);
  json_out(201, ['ok'=>true,'message'=>'Score stored']);
} catch (Throwable $e) {
  error_log((string)$e);
  json_out(500, ['ok'=>false,'error'=>'Could not save score']);
}
