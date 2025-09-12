</main>
<footer class="site-footer">
  <div class="container footer-inner">
    <p>© <?php echo date('Y'); ?> <?php echo e(config('owner')); ?>. Built with ❤️ and PHP.</p>
    <div class="socials">
      <?php $s = config('socials', []); ?>
      <?php if (!empty($s['github'])): ?><a href="<?php echo e($s['github']); ?>" target="_blank" rel="noopener">GitHub</a><?php endif; ?>
      <?php if (!empty($s['x'])): ?><a href="<?php echo e($s['x']); ?>" target="_blank" rel="noopener">X</a><?php endif; ?>
      <?php if (!empty($s['site'])): ?><a href="<?php echo e($s['site']); ?>" target="_blank" rel="noopener">Website</a><?php endif; ?>
      <?php if (!empty($s['huggingface'])): ?><a href="<?php echo e($s['huggingface']); ?>" target="_blank" rel="noopener">Hugging&nbsp;Face</a><?php endif; ?>
    </div>
  </div>
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
