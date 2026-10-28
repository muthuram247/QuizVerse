# QuizVerse PHP + MySQL backend — setup scaffold

GitHub Pages serves static files only. Upload this folder to a PHP 8.2+ hosting provider with MySQL 8+ support.

## Files
- `database/schema.sql`: database tables for users, scores, saved progress and multiplayer rooms.
- `api/config.example.php`: configuration template; copy to `config.php` on your server and set secrets there.
- `api/db.php`: PDO database connection.
- `api/health.php`: checks that the API and database connection work.
- `api/google-login.php`: verifies Google ID tokens using the Google API PHP Client library.
- `api/save-score.php`: saves a score for the authenticated account after token verification.

## Requirements
- PHP 8.2 or newer, PDO MySQL, Composer.
- Install Google API client on the host with `composer require google/apiclient:^2.0`.
- Configure Google OAuth Web Client ID in Google Cloud Console. Add the exact GitHub Pages origin and the PHP API origin to the appropriate allowed origins/redirect settings.
- Set `GOOGLE_CLIENT_ID`, DB credentials and `APP_ALLOWED_ORIGIN` as environment variables on the PHP host. Do not commit live credentials.
- Upload this API under a URL such as `https://your-api-host.example/api/`.

This scaffold is not a live multiplayer server yet. Real-time rooms require a WebSocket-capable service/server, or a managed realtime provider. The schema reserves room tables for that next stage. Never trust a score sent by the browser as proof of a valid result; production scoring should validate question IDs and answers server-side.
