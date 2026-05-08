<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1>新規登録</h1>
        <?= $this->Form->create($user) ?>
        <div class="mb-3">
            <?= $this->Form->control('name', ['label' => '名前', 'class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('email', ['label' => 'メール', 'class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('password', ['label' => 'パスワード', 'class' => 'form-control']) ?>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
        <?= $this->Form->end() ?>
    </div>
</div>
