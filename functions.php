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

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    $valid = isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $valid;
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

  // Defend against header injection: reject CRLF in any header-bound input.
  $rawEmail = trim((string)($payload['email'] ?? ''));
  if ($rawEmail !== '' && (strpos($rawEmail, "\r") !== false || strpos($rawEmail, "\n") !== false)) {
    return false;
  }

  // Validate the reply-to email (defense in depth, even if caller validates).
  $replyTo = '';
  if ($rawEmail !== '' && filter_var($rawEmail, FILTER_VALIDATE_EMAIL)) {
    $replyTo = $rawEmail;
  }

  // Subject is also header-adjacent; strip CRLF and keep it short.
  $rawSubject = (string)($payload['subject'] ?? 'New message');
  $safeSubject = trim(str_replace(["\r", "\n"], '', $rawSubject));
  if ($safeSubject === '') {
    $safeSubject = 'New message';
  }
  if (strlen($safeSubject) > 160) {
    $safeSubject = substr($safeSubject, 0, 160);
  }
  $subject = '[Portfolio] ' . $safeSubject;

  // Use a fixed From address; only set Reply-To to the visitor's address (when valid).
  $from = 'no-reply@example.com';
  $headers = 'From: Portfolio <' . $from . ">\r\n";
  if ($replyTo !== '') {
    $headers .= 'Reply-To: ' . $replyTo . "\r\n";
  }
  $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

  $name = (string)($payload['name'] ?? '');
  $message = (string)($payload['message'] ?? '');

  $body = "Name: {$name}\n";
  $body .= "Email: {$rawEmail}\n";
  $body .= "Subject: {$safeSubject}\n\n";
  $body .= $message . "\n";

  return function_exists('mail') ? @mail($to, $subject, $body, $headers) : false;
}
