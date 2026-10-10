<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A focused daily task manager built with CodeIgniter 4.">
    <title><?= esc($title) ?> | Tasks for Today</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <div class="site-shell">
        <header class="site-header">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Tasks for Today home">
                <span class="brand-mark" aria-hidden="true">T</span>
                <span><strong>Tasks for Today</strong><small>Daily work, clearly framed</small></span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
                <span></span><span></span><span class="sr-only">Toggle navigation</span>
            </button>

            <nav class="primary-nav" id="primary-nav" aria-label="Primary navigation">
                <a class="<?= $active === 'home' ? 'is-active' : '' ?>" href="<?= site_url('/') ?>">Today</a>
                <a class="<?= $active === 'tasks' ? 'is-active' : '' ?>" href="<?= site_url('tasks') ?>">Task list</a>
                <a class="<?= $active === 'profile' ? 'is-active' : '' ?>" href="<?= site_url('profile') ?>">Profile</a>
                <a class="<?= $active === 'about' ? 'is-active' : '' ?>" href="<?= site_url('about') ?>">About</a>
                <?php if (session()->get('isLoggedIn')): ?>
                    <span class="nav-account">
                        <span><?= esc(session('fullName')) ?></span>
                        <form action="<?= site_url('logout') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit">Log out</button>
                        </form>
                    </span>
                <?php else: ?>
                    <a class="<?= $active === 'login' ? 'is-active' : '' ?>" href="<?= site_url('login') ?>">Login</a>
                <?php endif ?>
            </nav>
        </header>

        <main>
            <?php if ($message = session()->getFlashdata('message')): ?>
                <div class="flash-message" role="status"><?= esc($message) ?></div>
            <?php endif ?>
            <?php if ($message = session()->getFlashdata('error')): ?>
                <div class="flash-message flash-error" role="alert"><?= esc($message) ?></div>
            <?php endif ?>
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="site-footer">
            <p>Tasks for Today Management System</p>
            <p>CodeIgniter 4 · <?= date('Y') ?></p>
        </footer>
    </div>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
