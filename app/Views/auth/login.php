<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="auth-layout">
    <div>
        <p class="eyebrow">Task management access</p>
        <h1>Sign in to manage the plan.</h1>
        <p class="hero-copy">Anyone can review the schedule. Only the authenticated task coordinator can create, edit, complete, or archive tasks.</p>
    </div>

    <div class="form-panel auth-panel">
        <?php if ($errors = session('errors')): ?>
            <div class="form-errors" role="alert">
                <strong>Please check the form.</strong>
                <ul>
                    <?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="<?= esc(old('username'), 'attr') ?>" autocomplete="username" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>
            </div>
            <button class="button button-primary button-full" type="submit">Log in</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
