<?php
// Dev router for `php -S localhost:8080 router-dev.php` (mimics .htaccess).
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file) && !preg_match('#^/(includes|pages|sql|storage)/|^/config\.php$#', $path)) {
    return false; // serve static file / admin php directly
}
require __DIR__ . '/index.php';
