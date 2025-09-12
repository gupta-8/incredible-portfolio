<?php require __DIR__ . '/../data/projects.php'; $featured = array_filter($projects, fn($p)=>!empty($p['featured'])); ?>
<section class="hero">
  <div>
    <h1>Hello, I’m <?php echo e(config('owner')); ?>.</h1>
    <p class="lead"><?php echo e(config('tagline')); ?></p>
    <div class="cta">
      <a class="btn primary" href="./?page=projects">See Projects</a>
      <a class="btn" href="./?page=contact">Contact Me</a>
    </div>
  </div>
  <div class="hero-card">
    <p><strong>Currently:</strong> Shipping WordPress builds with custom blocks & plugins.</p>
    <p><strong>Open to:</strong> Freelance and full-time roles.</p>
  </div>
</section>

<section>
  <h2>Featured Projects</h2>
  <div class="grid">
    <?php foreach ($featured as $p): ?>
      <article class="card project">
        <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['title']); ?> preview">
        <div class="card-body">
          <h3><?php echo e($p['title']); ?></h3>
          <p><?php echo e($p['description']); ?></p>
          <div class="tags">
            <?php foreach ($p['tech'] as $t): ?><span class="tag"><?php echo e($t); ?></span><?php endforeach; ?>
          </div>
          <div class="actions">
            <?php if(!empty($p['live'])): ?><a class="btn small" target="_blank" href="<?php echo e($p['live']); ?>">Live</a><?php endif; ?>
            <?php if(!empty($p['source'])): ?><a class="btn small" target="_blank" href="<?php echo e($p['source']); ?>">Source</a><?php endif; ?>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>
