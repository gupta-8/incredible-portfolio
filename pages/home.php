<?php
require __DIR__ . '/../data/projects.php';

$featured = array_filter($projects, fn($p) => !empty($p['featured']));
if (empty($featured)) {
    // Fallback: take first few projects if none are explicitly marked as featured
    $featured = array_slice($projects, 0, 3);
}

$totalProjects = count($projects);
?>

<section class="hero" id="top">
    <div class="hero-content">
        <p class="hero-kicker">Developer · Builder · Problem Solver</p>

        <h1>
            Hello, I’m <?php echo e(config('owner')); ?>.
        </h1>

        <p class="lead">
            <?php echo e(config('tagline')); ?>
        </p>

        <p class="hero-subtitle">
            I design and build fast, minimal interfaces and practical tooling that solves real problems.
        </p>

        <div class="cta">
            <a class="btn primary" href="./?page=projects">
                See Projects
            </a>
            <a class="btn" href="./?page=contact">
                Contact Me
            </a>
        </div>

        <div class="hero-highlights">
            <div class="hero-highlight">
                <span class="hero-highlight-label">Projects</span>
                <span class="hero-highlight-value">
                    <?php echo e($totalProjects); ?>+
                </span>
            </div>
            <div class="hero-highlight">
                <span class="hero-highlight-label">Focus</span>
                <span class="hero-highlight-value">
                    Clean UX · Solid engineering
                </span>
            </div>
            <div class="hero-highlight">
                <span class="hero-highlight-label">Stack</span>
                <span class="hero-highlight-value">
                    PHP · JS · CSS · WordPress
                </span>
            </div>
        </div>
    </div>

    <div class="hero-card" aria-label="Current work and availability">
        <p class="hero-card-label">Now</p>
        <p class="hero-card-line">
            <strong>Currently:</strong>
            Shipping WordPress builds with custom blocks &amp; plugins.
        </p>
        <p class="hero-card-line">
            <strong>Open to:</strong>
            Freelance and full-time roles.
        </p>

        <div class="hero-card-divider"></div>

        <ul class="hero-card-list">
            <li>Responsive, fast-loading frontends</li>
            <li>Clean, maintainable PHP backends</li>
            <li>Small tools &amp; automation for teams</li>
        </ul>
    </div>
</section>

<section class="section section-featured" aria-labelledby="featured-heading">
    <header class="section-header">
        <h2 id="featured-heading">Featured Projects</h2>
        <p class="section-subtitle">
            A few things I’m proud of. Explore more work on the projects page.
        </p>
    </header>

    <?php if (!empty($featured)): ?>
        <div class="grid">
            <?php foreach ($featured as $p): ?>
                <article class="card project">
                    <?php if (!empty($p['image'])): ?>
                        <div class="card-media">
                            <img
                                src="<?php echo e($p['image']); ?>"
                                alt="<?php echo e($p['title']); ?> preview"
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h3><?php echo e($p['title']); ?></h3>

                        <p class="card-text">
                            <?php echo e($p['description']); ?>
                        </p>

                        <?php if (!empty($p['tech'])): ?>
                            <div class="tags" aria-label="Tech stack">
                                <?php foreach ($p['tech'] as $t): ?>
                                    <span class="tag"><?php echo e($t); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="actions">
                            <?php if (!empty($p['live'])): ?>
                                <a
                                    class="btn small"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    href="<?php echo e($p['live']); ?>"
                                >
                                    Live
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($p['source'])): ?>
                                <a
                                    class="btn small"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    href="<?php echo e($p['source']); ?>"
                                >
                                    Source
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="muted">
            No featured projects yet. <a href="./?page=projects">View all projects</a>.
        </p>
    <?php endif; ?>

    <div class="section-footer">
        <a class="btn ghost" href="./?page=projects">
            View all projects
        </a>
    </div>
</section>
