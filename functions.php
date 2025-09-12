<?php
declare(strict_types=1);
session_start();

function config(string $key, $default = null) {
  static $cfg = null;
  if ($cfg === null) {
    $cfg = require __DIR__ . '/config.php';
  }
  return $cfg[$key] ?? $default;
}

function e(string $v): string {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function active(string $page): string {
  $current = $_GET['page'] ?? 'home';
  return $current === $page ? 'active' : '';
}

function csrf_token(): string {
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }
  return $_SESSION['csrf'];
}

function verify_csrf(string $token): bool {
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function save_message(array $payload): void {
  $file = __DIR__ . '/storage/messages.csv';
  $isNew = !file_exists($file);
  $fp = fopen($file, 'a');
  if ($isNew) {
    fputcsv($fp, ['timestamp','name','email','subject','message','ip']);
  }
  fputcsv($fp, [
    date('c'),
    $payload['name'] ?? '',
    $payload['email'] ?? '',
    $payload['subject'] ?? '',
    $payload['message'] ?? '',
    $_SERVER['REMOTE_ADDR'] ?? 'unknown'
  ]);
  fclose($fp);
}

function attempt_mail(array $payload): bool {
  $to = config('contact_email');
  $subject = '[Portfolio] ' . ($payload['subject'] ?? 'New message');
  $headers = 'From: ' . ($payload['email'] ?? 'no-reply@example.com') . "\r\n";
  $headers .= 'Reply-To: ' . ($payload['email'] ?? 'no-reply@example.com') . "\r\n";
  $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
  $body = "Name: {$payload['name']}\nEmail: {$payload['email']}\nSubject: {$payload['subject']}\n\n{$payload['message']}\n";
  return function_exists('mail') ? @mail($to, $subject, $body, $headers) : false;
}
