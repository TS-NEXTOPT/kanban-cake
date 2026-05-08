<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
$canEdit = $this->Identity->can('edit', $task);
?>
<h1><?= h($task->title) ?></h1>
<p class="text-muted">プロジェクト: <?= $this->Html->link(h($task->project->name), ['controller' => 'Projects', 'action' => 'view', $task->project_id]) ?></p>

<dl class="row">
    <dt class="col-sm-2">状態</dt><dd class="col-sm-10"><?= h($task->status) ?></dd>
    <dt class="col-sm-2">優先度</dt><dd class="col-sm-10"><?= h($task->priority) ?></dd>
    <dt class="col-sm-2">期限</dt><dd class="col-sm-10"><?= $task->due_date ? '<span class="' . ($task->is_overdue ? 'text-danger fw-bold' : '') . '">' . h($task->due_date->format('Y-m-d')) . ($task->is_overdue ? ' (期限切れ)' : '') . '</span>' : '-' ?></dd>
    <dt class="col-sm-2">担当</dt><dd class="col-sm-10"><?= $task->assignee ? h($task->assignee->name) : '-' ?></dd>
    <dt class="col-sm-2">作成者</dt><dd class="col-sm-10"><?= h($task->creator->name) ?></dd>
    <dt class="col-sm-2">タグ</dt><dd class="col-sm-10"><?php foreach ($task->tags as $tag): ?><span class="badge text-bg-secondary me-1"><?= h($tag->name) ?></span><?php endforeach; ?></dd>
</dl>
<p><?= nl2br(h($task->body)) ?></p>

<?php if ($canEdit): ?>
<p>
    <?= $this->Html->link('編集', ['action' => 'edit', $task->id], ['class' => 'btn btn-outline-primary me-2']) ?>
    <?= $this->Form->postLink('削除', ['action' => 'delete', $task->id], ['class' => 'btn btn-outline-danger', 'confirm' => '削除しますか？']) ?>
</p>
<?php endif; ?>

<h2 class="mt-4">コメント</h2>
<?php foreach ($task->comments as $c): ?>
    <div class="border rounded p-3 mb-2">
        <strong><?= h($c->user->name) ?></strong> <small class="text-muted"><?= h($c->created->format('Y-m-d H:i')) ?></small>
        <p class="mb-0"><?= nl2br(h($c->body)) ?></p>
        <?php if ($this->Identity->can('delete', $c)): ?>
            <?= $this->Form->postLink('削除', ['controller' => 'Comments', 'action' => 'delete', $c->id], ['class' => 'btn btn-sm btn-link text-danger', 'confirm' => '削除しますか？']) ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'Comments', 'action' => 'add', $task->id]]) ?>
<div class="mb-3"><?= $this->Form->control('body', ['label' => false, 'class' => 'form-control', 'rows' => 3, 'placeholder' => 'コメントを投稿']) ?></div>
<button type="submit" class="btn btn-primary">投稿</button>
<?= $this->Form->end() ?>
