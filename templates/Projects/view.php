<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
$canEdit = $this->Identity->can('edit', $project);
?>
<h1><?= h($project->name) ?></h1>
<p class="text-muted">作成者: <?= h($project->creator->name) ?> / 作成日: <?= h($project->created->format('Y-m-d')) ?></p>
<p><?= nl2br(h($project->description)) ?></p>

<?php if ($canEdit): ?>
    <p>
        <?= $this->Html->link('編集', ['action' => 'edit', $project->id], ['class' => 'btn btn-outline-primary me-2']) ?>
        <?= $this->Form->postLink('削除', ['action' => 'delete', $project->id], ['class' => 'btn btn-outline-danger', 'confirm' => '削除しますか？']) ?>
    </p>
<?php endif; ?>

<h2>メンバー</h2>
<table class="table">
    <thead><tr><th>名前</th><th>役割</th><?php if ($canEdit): ?><th>操作</th><?php endif; ?></tr></thead>
    <tbody>
        <?php foreach ($project->members as $m): ?>
            <tr>
                <td><?= h($m->name) ?> (<?= h($m->email) ?>)</td>
                <td><?= h($m->_joinData->role) ?></td>
                <?php if ($canEdit): ?>
                    <td>
                        <?php if ($m->_joinData->role !== 'owner'): ?>
                            <?= $this->Form->postLink('削除', ['action' => 'removeMember', $project->id, $m->id], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => '削除しますか？']) ?>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($canEdit): ?>
    <h3>メンバー追加</h3>
    <?= $this->Form->create(null, ['url' => ['action' => 'addMember', $project->id]]) ?>
    <div class="row g-2">
        <div class="col-auto"><?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'メールアドレス']) ?></div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">追加</button></div>
    </div>
    <?= $this->Form->end() ?>
<?php endif; ?>

<h2 class="mt-4">タスク統計</h2>
<div class="row">
    <div class="col"><div class="card text-bg-secondary"><div class="card-body"><h5>todo</h5><p class="display-6 mb-0"><?= h($stats['todo']) ?></p></div></div></div>
    <div class="col"><div class="card text-bg-info"><div class="card-body"><h5>doing</h5><p class="display-6 mb-0"><?= h($stats['doing']) ?></p></div></div></div>
    <div class="col"><div class="card text-bg-success"><div class="card-body"><h5>done</h5><p class="display-6 mb-0"><?= h($stats['done']) ?></p></div></div></div>
</div>

<h2 class="mt-4">タスク一覧</h2>
<p><?= $this->Html->link('タスク追加', ['controller' => 'Tasks', 'action' => 'add', $project->id], ['class' => 'btn btn-primary mb-2']) ?></p>
<table class="table table-hover">
    <thead><tr><th>タイトル</th><th>状態</th><th>優先度</th><th>担当</th><th>期限</th><th>タグ</th></tr></thead>
    <tbody>
        <?php foreach ($tasks as $t): ?>
            <tr>
                <td><?= $this->Html->link(h($t->title), ['controller' => 'Tasks', 'action' => 'view', $t->id]) ?></td>
                <td><?= h($t->status) ?></td>
                <td><?= h($t->priority) ?></td>
                <td><?= $t->assignee ? h($t->assignee->name) : '-' ?></td>
                <td><?= $t->due_date ? '<span class="' . ($t->is_overdue ? 'text-danger fw-bold' : '') . '">' . h($t->due_date->format('Y-m-d')) . '</span>' : '-' ?></td>
                <td><?php foreach ($t->tags as $tag): ?><span class="badge text-bg-secondary me-1"><?= h($tag->name) ?></span><?php endforeach; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mt-4">最近のコメント</h2>
<?php if (count($recentComments) === 0): ?>
    <p>コメントなし</p>
<?php else: ?>
    <ul class="list-group">
        <?php foreach ($recentComments as $c): ?>
            <li class="list-group-item">
                <strong><?= h($c->user->name) ?></strong> on <?= $this->Html->link(h($c->task->title), ['controller' => 'Tasks', 'action' => 'view', $c->task_id]) ?>
                <small class="text-muted"><?= h($c->created->format('Y-m-d H:i')) ?></small>
                <p class="mb-0"><?= h($c->body) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
