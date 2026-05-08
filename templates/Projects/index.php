<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $projects
 */
?>
<h1>参加プロジェクト</h1>
<p><?= $this->Html->link('新規作成', ['action' => 'add'], ['class' => 'btn btn-primary mb-3']) ?></p>
<table class="table table-hover">
    <thead><tr><th>名前</th><th>作成日</th><th>操作</th></tr></thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $this->Html->link(h($project->name), ['action' => 'view', $project->id]) ?></td>
                <td><?= h($project->created->format('Y-m-d')) ?></td>
                <td><?= $this->Html->link('詳細', ['action' => 'view', $project->id], ['class' => 'btn btn-sm btn-outline-primary']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->Paginator->numbers() ?>
