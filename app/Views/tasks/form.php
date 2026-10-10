<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro compact-intro">
    <p class="eyebrow"><?= $isEdit ? 'Edit task' : 'New task' ?></p>
    <h1><?= esc($heading) ?></h1>
</section>

<section class="form-panel task-form-panel">
    <?php if ($errors = session('errors')): ?>
        <div class="form-errors" role="alert">
            <strong>Please check the form.</strong>
            <ul>
                <?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= esc($formAction, 'attr') ?>" method="post">
        <?= csrf_field() ?>
        <div class="field">
            <label for="title">Task title</label>
            <input id="title" name="title" type="text" maxlength="150" value="<?= esc(old('title', $task['title'] ?? ''), 'attr') ?>" required>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="task_date">Task date</label>
                <input id="task_date" name="task_date" type="date" value="<?= esc(old('task_date', $task['task_date'] ?? date('Y-m-d')), 'attr') ?>" required>
            </div>
            <div class="field">
                <label for="status">Status</label>
                <?php $selectedStatus = old('status', $task['status'] ?? 'pending'); ?>
                <select id="status" name="status" required>
                    <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= $selectedStatus === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                    <option value="completed" <?= $selectedStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button class="button button-primary" type="submit"><?= $isEdit ? 'Save changes' : 'Create task' ?></button>
            <a class="button button-secondary" href="<?= site_url('tasks') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
