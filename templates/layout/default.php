<?php
/**
 * @var \App\View\AppView $this
 */
$cakeDescription = 'KanbanCake';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $cakeDescription ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <?= $this->Html->link('KanbanCake', ['controller' => 'Pages', 'action' => 'display', 'home'], ['class' => 'navbar-brand']) ?>
        <ul class="navbar-nav me-auto">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <li class="nav-item"><?= $this->Html->link('ダッシュボード', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('プロジェクト', ['controller' => 'Projects', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('検索', ['controller' => 'Search', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <li class="nav-item"><span class="nav-link"><?= h($this->Identity->get('name')) ?></span></li>
                <li class="nav-item">
                    <?= $this->Form->postLink('ログアウト', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link btn btn-link']) ?>
                </li>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link('ログイン', ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('新規登録', ['controller' => 'Users', 'action' => 'register'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<main class="container py-4">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
