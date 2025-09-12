<?php require __DIR__ . '/../data/projects.php'; ?>
<section>
  <h1>Projects</h1>
  <p class="lead">A selection of things I’ve designed, built, and shipped.</p>
  <div class="grid">
    <?php foreach ($projects as $p): ?>
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
