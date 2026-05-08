<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold">KanbanCake</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">社内向け簡易プロジェクト・タスク管理ツール</p>
        <?php if (!$this->Identity->isLoggedIn()): ?>
            <?= $this->Html->link('ログイン', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn btn-primary btn-lg me-2']) ?>
            <?= $this->Html->link('新規登録', ['controller' => 'Users', 'action' => 'register'], ['class' => 'btn btn-outline-primary btn-lg']) ?>
        <?php else: ?>
            <?= $this->Html->link('ダッシュボードへ', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'btn btn-primary btn-lg']) ?>
        <?php endif; ?>
    </div>
</div>
