<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 * @var \App\Model\Entity\User[] $members
 */
$memberOptions = ['' => '(未割当)'];
foreach ($members as $m) {
    $memberOptions[$m->id] = $m->name;
}
$tagNames = implode(', ', array_map(fn($t) => $t->name, $task->tags));
?>
<h1>タスク編集</h1>
<?= $this->Form->create($task) ?>
<div class="mb-3"><?= $this->Form->control('title', ['label' => 'タイトル', 'class' => 'form-control']) ?></div>
<div class="mb-3"><?= $this->Form->control('body', ['label' => '本文', 'class' => 'form-control', 'rows' => 4]) ?></div>
<div class="row">
    <div class="col-md-3 mb-3"><?= $this->Form->control('status', ['options' => ['todo' => 'todo', 'doing' => 'doing', 'done' => 'done'], 'class' => 'form-select']) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('priority', ['options' => ['low' => 'low', 'medium' => 'medium', 'high' => 'high'], 'class' => 'form-select']) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('due_date', ['type' => 'date', 'class' => 'form-control', 'empty' => true]) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('assigned_to', ['options' => $memberOptions, 'class' => 'form-select']) ?></div>
</div>
<div class="mb-3"><?= $this->Form->control('tag_names', ['label' => 'タグ (カンマ区切り)', 'value' => $tagNames, 'class' => 'form-control']) ?></div>
<button type="submit" class="btn btn-primary">更新</button>
<?= $this->Form->end() ?>
