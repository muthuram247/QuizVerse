<?php
declare(strict_types=1);
$config = require __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: ' . $config['allowed_origin']);
header('Vary: Origin');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
function json_out(int $status, array $body): never {
  http_response_code($status);
  echo json_encode($body, JSON_UNESCAPED_SLASHES);
  exit;
}
function db(): PDO {
  static $pdo = null;
  global $config;
  if ($pdo instanceof PDO) return $pdo;
  $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4';
  $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
  return $pdo;
}
function read_json(): array {
  $raw = file_get_contents('php://input');
  $data = json_decode($raw ?: '{}', true);
  if (!is_array($data)) json_out(400, ['ok'=>false,'error'=>'Invalid JSON body']);
  return $data;
}
function google_user_from_bearer(): array {
  global $config;
  $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
  if (!preg_match('/^Bearer\s+(.+)$/i', $header, $m)) json_out(401, ['ok'=>false,'error'=>'Missing Google ID token']);
  if (!is_file(__DIR__ . '/../vendor/autoload.php')) json_out(503, ['ok'=>false,'error'=>'Google API client library is not installed on the server']);
  require_once __DIR__ . '/../vendor/autoload.php';
  $client = new Google\Client(['client_id' => $config['google_client_id']]);
  $payload = $client->verifyIdToken($m[1]);
  if (!$payload || empty($payload['sub']) || empty($payload['email']) || empty($payload['email_verified'])) {
    json_out(401, ['ok'=>false,'error'=>'Google ID token could not be verified']);
  }
  return $payload;
}
