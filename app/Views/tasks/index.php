<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <p class="eyebrow">Complete archive</p>
    <div class="intro-row">
        <h1>Every task,<br>in sequence.</h1>
        <div class="intro-actions">
            <p><?= esc((string) $total) ?> tasks across <?= esc((string) count($groups)) ?> dates, ordered from earliest to latest so the full workload stays visible.</p>
            <?php if (session()->get('isLoggedIn')): ?><a class="button button-primary" href="<?= site_url('tasks/new') ?>">New task</a><?php endif ?>
        </div>
    </div>
</section>

<section class="timeline" aria-label="All tasks grouped by date">
    <?php if ($groups === []): ?>
        <div class="empty-state"><span aria-hidden="true">○</span><h3>No active tasks</h3><p>Create a new task or check that existing records have not been archived.</p></div>
    <?php endif ?>
    <?php foreach ($groups as $taskDate => $tasks): ?>
        <?php $date = new DateTimeImmutable($taskDate); ?>
        <div class="timeline-group">
            <div class="timeline-date"><span><?= esc($date->format('D')) ?></span><strong><?= esc($date->format('d')) ?></strong><small><?= esc($date->format('M Y')) ?></small></div>
            <div class="timeline-items">
                <?php foreach ($tasks as $task): ?>
                    <?php $isCompleted = $task['status'] === 'completed'; ?>
                    <article class="timeline-task <?= $isCompleted ? 'is-completed' : '' ?>">
                        <div class="timeline-task-main">
                            <?php if (session()->get('isLoggedIn')): ?>
                                <form class="task-check-form" method="post" action="<?= site_url('tasks/' . $task['id'] . '/toggle') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="return_to" value="tasks">
                                    <button class="task-check <?= $isCompleted ? 'is-checked' : '' ?>" type="submit" aria-label="<?= $isCompleted ? 'Reopen' : 'Complete' ?> <?= esc($task['title']) ?>" aria-pressed="<?= $isCompleted ? 'true' : 'false' ?>">
                                        <span class="sr-only"><?= $isCompleted ? 'Completed' : 'Not completed' ?></span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="task-check static-check <?= $isCompleted ? 'is-checked' : '' ?>" aria-hidden="true"></span>
                            <?php endif ?>
                            <div><h2><?= esc($task['title']) ?></h2><p>Task #<?= esc(str_pad((string) $task['id'], 3, '0', STR_PAD_LEFT)) ?></p></div>
                        </div>
                        <div class="task-side">
                            <span class="status status-<?= esc(str_replace('_', '-', $task['status'])) ?>"><?= esc(ucwords(str_replace('_', ' ', $task['status']))) ?></span>
                            <?php if (session()->get('isLoggedIn')): ?>
                                <div class="task-actions">
                                    <a href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a>
                                    <form action="<?= site_url('tasks/' . $task['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Archive this task?');">
                                        <?= csrf_field() ?>
                                        <button type="submit">Archive</button>
                                    </form>
                                </div>
                            <?php endif ?>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</section>
<?= $this->endSection() ?>
