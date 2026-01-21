<section class="section">
  <header class="section-header">
    <div>
      <h1 class="section-title">Page not found</h1>
      <p class="lead">
        The page you requested doesn’t exist (or may have been moved).
      </p>
    </div>
  </header>

  <?php $requested = trim((string)($_GET['page'] ?? '')); ?>
  <?php if ($requested !== '' && $requested !== '404'): ?>
    <p class="lead">
      Requested: <strong><?php echo e($requested); ?></strong>
    </p>
  <?php endif; ?>

  <div class="cta" style="margin-top: 1rem;">
    <a class="btn primary" href="./?page=home">Go to Home</a>
    <a class="btn" href="./?page=projects">View Projects</a>
    <a class="btn" href="./?page=contact">Contact</a>
  </div>
</section>
