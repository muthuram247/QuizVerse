<?php
// Copy to config.php on your PHP host. Never commit real secrets.
return [
  'db_host' => getenv('DB_HOST') ?: 'localhost',
  'db_name' => getenv('DB_NAME') ?: 'quizverse',
  'db_user' => getenv('DB_USER') ?: 'quizverse_user',
  'db_pass' => getenv('DB_PASS') ?: '',
  'google_client_id' => getenv('GOOGLE_CLIENT_ID') ?: '',
  'allowed_origin' => getenv('APP_ALLOWED_ORIGIN') ?: 'https://YOUR-USERNAME.github.io',
];
