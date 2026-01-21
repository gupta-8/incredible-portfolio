<?php
require __DIR__ . '/functions.php';

$page = $_GET['page'] ?? 'home';

// Allow explicit 404 route too
$allowed = ['home', 'projects', 'about', 'contact', '404'];

if (!in_array($page, $allowed, true)) {
  http_response_code(404);
  $page = '404';
}

// If someone directly visits ?page=404, ensure status is correct
if ($page === '404') {
  http_response_code(404);
}

require __DIR__ . '/header.php';
require __DIR__ . '/pages/' . $page . '.php';
require __DIR__ . '/footer.php';
