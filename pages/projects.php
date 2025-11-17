<?php

// Load the $projects array from data/projects.php (your file above)
require __DIR__ . '/../data/projects.php';

/**
 * Build a lowercase searchable string from a project.
 *
 * Uses: title + description + tech[]
 */
function build_project_search_text(array $project): string
{
    $parts = [];

    if (!empty($project['title'])) {
        $parts[] = $project['title'];
    }

    if (!empty($project['description'])) {
        $parts[] = $project['description'];
    }

    if (!empty($project['tech']) && is_array($project['tech'])) {
        $parts = array_merge($parts, $project['tech']);
    }

    $text = trim(implode(' ', $parts));

    if ($text === '') {
        return '';
    }

    if (function_exists('mb_strtolower')) {
        return mb_strtolower($text, 'UTF-8');
    }

    return strtolower($text);
}

?>

<section class="section section-projects">
    <div class="container">

        <header class="section-header">
            <h1 class="section-title">Projects</h1>
            <p class="section-subtitle">
                A selection of things I’ve built, from small experiments to full products.
            </p>
        </header>

        <!-- Search / filter input -->
        <div class="projects-search">
            <label class="projects-search-label" for="projects-search">
                Search projects
            </label>

            <input
                type="search"
                id="projects-search"
                class="projects-search-input"
                name="q"
                placeholder="Search projects by name, description, or tech…"
                aria-label="Search projects"
                autocomplete="off"
                data-project-search
            >
        </div>

        <!-- “No results” message (shown only when nothing matches) -->
        <p class="projects-empty-message" data-projects-empty hidden>
            No projects found. Try a different keyword or clear the search.
        </p>

        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <?php
                    $title       = $project['title']       ?? '';
                    $description = $project['description'] ?? '';
                    $image       = $project['image']       ?? '';
                    $tech        = $project['tech']        ?? [];
                    $live        = $project['live']        ?? '';
                    $source      = $project['source']      ?? '';

                    $searchText  = build_project_search_text($project);
                ?>

                <article
                    class="project-card"
                    data-project-card
                    data-search="<?= e($searchText); ?>"
                >
                    <?php if (!empty($image)): ?>
                        <div class="project-card__image-wrapper">
                            <img
                                src="<?= e($image); ?>"
                                alt="<?= e($title !== '' ? $title : 'Project screenshot'); ?>"
                                class="project-card__image"
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>

                    <div class="project-card__body">
                        <?php if ($title !== ''): ?>
                            <h2 class="project-card__title">
                                <?= e($title); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ($description !== ''): ?>
                            <p class="project-card__description">
                                <?= e($description); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($tech) && is_array($tech)): ?>
                            <ul class="project-card__tech-list" aria-label="Tech stack">
                                <?php foreach ($tech as $techItem): ?>
                                    <li class="project-card__tech-tag">
                                        <?= e($techItem); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($live || $source): ?>
                            <div class="project-card__links">
                                <?php if ($live): ?>
                                    <a
                                        class="project-card__link project-card__link--live"
                                        href="<?= e($live); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Live Demo
                                    </a>
                                <?php endif; ?>

                                <?php if ($source): ?>
                                    <a
                                        class="project-card__link project-card__link--source"
                                        href="<?= e($source); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Source Code
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
