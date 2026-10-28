<?php
require __DIR__ . '/db.php';
try {
  db()->query('SELECT 1');
  json_out(200, ['ok'=>true,'service'=>'QuizVerse API','database'=>'connected']);
} catch (Throwable $e) {
  error_log((string)$e);
  json_out(500, ['ok'=>false,'error'=>'Database connection failed']);
}
