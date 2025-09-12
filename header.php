<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo e(config('tagline')); ?>">
  <meta name="theme-color" content="#0f172a">
  <title><?php echo e(config('site_name')); ?> • <?php echo e(config('tagline')); ?></title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a href="./" class="brand">
      <span class="logo">HG</span>
      <div class="brand-text">
        <strong><?php echo e(config('site_name')); ?></strong>
        <span><?php echo e(config('tagline')); ?></span>
      </div>
    </a>
    <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
    <nav class="site-nav" id="site-nav">
      <a class="<?php echo active('home'); ?>" href="./?page=home">Home</a>
      <a class="<?php echo active('projects'); ?>" href="./?page=projects">Projects</a>
      <a class="<?php echo active('about'); ?>" href="./?page=about">About</a>
      <a class="<?php echo active('contact'); ?>" href="./?page=contact">Contact</a>
      <button id="theme-toggle" class="btn small ghost" aria-label="Toggle theme">🌓</button>
    </nav>
  </div>
</header>
<main class="container">
