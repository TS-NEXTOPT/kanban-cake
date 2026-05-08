<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
?>
<h1>新規プロジェクト</h1>
<?= $this->Form->create($project) ?>
<div class="mb-3"><?= $this->Form->control('name', ['label' => '名前', 'class' => 'form-control']) ?></div>
<div class="mb-3"><?= $this->Form->control('description', ['label' => '説明', 'class' => 'form-control', 'rows' => 4]) ?></div>
<button type="submit" class="btn btn-primary">作成</button>
<?= $this->Form->end() ?>
