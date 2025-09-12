<?php
$sent = false;
$errors = [];
$old = ['name'=>'','email'=>'','subject'=>'','message'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old['name'] = trim($_POST['name'] ?? '');
  $old['email'] = trim($_POST['email'] ?? '');
  $old['subject'] = trim($_POST['subject'] ?? '');
  $old['message'] = trim($_POST['message'] ?? '');
  $token = $_POST['csrf'] ?? '';

  if (!verify_csrf($token)) $errors[] = 'Invalid form token. Please try again.';
  if ($old['name'] === '') $errors[] = 'Name is required.';
  if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if ($old['message'] === '') $errors[] = 'Message cannot be empty.';

  if (!$errors) {
    save_message($old);
    attempt_mail($old);
    $sent = true;
    $old = ['name'=>'','email'=>'','subject'=>'','message'=>''];
  }
}
?>
<section>
  <h1>Contact</h1>
  <p class="lead">Prefer email? Write to <a href="mailto:<?php echo e(config('contact_email')); ?>"><?php echo e(config('contact_email')); ?></a>. For quick calls, mention a time window and topic.</p>

  <div class="grid">
    <div class="card">
      <div class="card-body">
        <h3>Direct</h3>
        <?php $s = config('socials', []); ?>
        <ul>
          <li>Email: <a href="mailto:<?php echo e(config('contact_email')); ?>"><?php echo e(config('contact_email')); ?></a></li>
          <?php if (!empty($s['site'])): ?><li>Website: <a href="<?php echo e($s['site']); ?>" target="_blank" rel="noopener"><?php echo e($s['site']); ?></a></li><?php endif; ?>
          <?php if (!empty($s['x'])): ?><li>X: <a href="<?php echo e($s['x']); ?>" target="_blank" rel="noopener">@harshguptame</a></li><?php endif; ?>
          <?php if (!empty($s['github'])): ?><li>GitHub: <a href="<?php echo e($s['github']); ?>" target="_blank" rel="noopener">gupta-8</a></li><?php endif; ?>
          <?php if (!empty($s['huggingface'])): ?><li>Hugging Face: <a href="<?php echo e($s['huggingface']); ?>" target="_blank" rel="noopener">harshguptame</a></li><?php endif; ?>
        </ul>
      </div>
    </div>

    <form method="post" class="card form">
      <?php if ($sent): ?><div class="alert success">Thanks! Your message has been sent.</div><?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert error"><ul><?php foreach ($errors as $e): ?><li><?php echo e($e); ?></li><?php endforeach; ?></ul></div>
      <?php endif; ?>
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <label><span>Name</span><input name="name" required value="<?php echo e($old['name']); ?>"></label>
      <label><span>Email</span><input type="email" name="email" required value="<?php echo e($old['email']); ?>"></label>
      <label><span>Subject</span><input name="subject" value="<?php echo e($old['subject']); ?>"></label>
      <label><span>Message</span><textarea name="message" rows="6" required><?php echo e($old['message']); ?></textarea></label>
      <button class="btn primary">Send</button>
    </form>
  </div>
</section>
