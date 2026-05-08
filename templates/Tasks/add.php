<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 * @var \App\Model\Entity\Project $project
 * @var \App\Model\Entity\User[] $members
 */
$memberOptions = ['' => '(未割当)'];
foreach ($members as $m) {
    $memberOptions[$m->id] = $m->name;
}
?>
<h1>タスク追加: <?= h($project->name) ?></h1>
<?= $this->Form->create($task) ?>
<div class="mb-3"><?= $this->Form->control('title', ['label' => 'タイトル', 'class' => 'form-control']) ?></div>
<div class="mb-3"><?= $this->Form->control('body', ['label' => '本文', 'class' => 'form-control', 'rows' => 4]) ?></div>
<div class="row">
    <div class="col-md-3 mb-3"><?= $this->Form->control('status', ['label' => '状態', 'options' => ['todo' => 'todo', 'doing' => 'doing', 'done' => 'done'], 'class' => 'form-select']) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('priority', ['label' => '優先度', 'options' => ['low' => 'low', 'medium' => 'medium', 'high' => 'high'], 'default' => 'medium', 'class' => 'form-select']) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('due_date', ['label' => '期限', 'type' => 'date', 'class' => 'form-control', 'empty' => true]) ?></div>
    <div class="col-md-3 mb-3"><?= $this->Form->control('assigned_to', ['label' => '担当', 'options' => $memberOptions, 'class' => 'form-select']) ?></div>
</div>
<div class="mb-3"><?= $this->Form->control('tag_names', ['label' => 'タグ (カンマ区切り)', 'class' => 'form-control', 'placeholder' => 'urgent, bug']) ?></div>
<button type="submit" class="btn btn-primary">作成</button>
<?= $this->Form->end() ?>
