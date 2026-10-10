<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$date = new DateTimeImmutable($today);
$completion = $counts['all'] > 0 ? (int) round(($counts['completed'] / $counts['all']) * 100) : 0;
?>
<section class="today-hero">
    <div class="today-heading">
        <p class="eyebrow">Daily overview</p>
        <h1>Make room for what matters.</h1>
        <p class="hero-copy">A focused view of the work scheduled for today—nothing from yesterday, nothing borrowed from tomorrow.</p>
    </div>
    <div class="date-stamp" aria-label="Today's date">
        <span><?= esc($date->format('l')) ?></span>
        <strong><?= esc($date->format('d')) ?></strong>
        <small><?= esc($date->format('F Y')) ?></small>
    </div>
</section>

<section class="metric-strip" aria-label="Today's task summary">
    <div class="metric metric-main"><span>Today</span><strong><?= esc((string) $counts['all']) ?></strong><small>scheduled tasks</small></div>
    <div class="metric"><span>Pending</span><strong><?= esc((string) $counts['pending']) ?></strong><small>ready to begin</small></div>
    <div class="metric"><span>In progress</span><strong><?= esc((string) $counts['in_progress']) ?></strong><small>moving now</small></div>
    <div class="metric"><span>Complete</span><strong><?= esc((string) $completion) ?>%</strong><small>of today's list</small></div>
</section>

<section class="task-section">
    <div class="section-heading">
        <div><p class="eyebrow">Today’s queue</p><h2>One clear list</h2></div>
        <div class="heading-actions">
            <?php if (session()->get('isLoggedIn')): ?><a class="button button-primary" href="<?= site_url('tasks/new') ?>">New task</a><?php endif ?>
            <a class="text-link" href="<?= site_url('tasks') ?>">See every date <span aria-hidden="true">→</span></a>
        </div>
    </div>

    <?php if ($tasks === []): ?>
        <div class="empty-state"><span aria-hidden="true">○</span><h3>The day is open</h3><p>No tasks are scheduled for today. Add records through the database seeder or task table.</p></div>
    <?php else: ?>
        <div class="task-stack">
            <?php foreach ($tasks as $index => $task): ?>
                <?php $isCompleted = $task['status'] === 'completed'; ?>
                <article class="task-card <?= $isCompleted ? 'is-completed' : '' ?>">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <form class="task-check-form" method="post" action="<?= site_url('tasks/' . $task['id'] . '/toggle') ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="return_to" value="today">
                            <button class="task-check <?= $isCompleted ? 'is-checked' : '' ?>" type="submit" aria-label="<?= $isCompleted ? 'Reopen' : 'Complete' ?> <?= esc($task['title']) ?>" aria-pressed="<?= $isCompleted ? 'true' : 'false' ?>">
                                <span class="sr-only"><?= $isCompleted ? 'Completed' : 'Not completed' ?></span>
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="task-check static-check <?= $isCompleted ? 'is-checked' : '' ?>" aria-hidden="true"></span>
                    <?php endif ?>
                    <span class="task-number"><?= esc(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <div class="task-copy"><h3><?= esc($task['title']) ?></h3><p>Scheduled for <?= esc($date->format('F j, Y')) ?></p></div>
                    <span class="status status-<?= esc(str_replace('_', '-', $task['status'])) ?>"><?= esc(ucwords(str_replace('_', ' ', $task['status']))) ?></span>
                </article>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</section>
<?= $this->endSection() ?>
