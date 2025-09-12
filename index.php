<?php
require __DIR__ . '/functions.php';
$page = $_GET['page'] ?? 'home';
$allowed = ['home','projects','about','contact'];
if (!in_array($page, $allowed, true)) {
  http_response_code(404);
  $page = 'home';
}
require __DIR__ . '/header.php';
require __DIR__ . '/pages/' . $page . '.php';
require __DIR__ . '/footer.php';
