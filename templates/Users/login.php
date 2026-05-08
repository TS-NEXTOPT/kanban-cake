<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1>ログイン</h1>
        <?= $this->Form->create() ?>
        <div class="mb-3">
            <label class="form-label">メール</label>
            <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <label class="form-label">パスワード</label>
            <?= $this->Form->control('password', ['label' => false, 'class' => 'form-control']) ?>
        </div>
        <button type="submit" class="btn btn-primary">ログイン</button>
        <?= $this->Form->end() ?>
    </div>
</div>
