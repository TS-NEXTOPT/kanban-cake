<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $tasks
 * @var string $q
 */
?>
<h1>タスク検索</h1>

<?= $this->Form->create(null, ['type' => 'get', 'url' => ['controller' => 'Search', 'action' => 'index'], 'class' => 'mb-3']) ?>
    <div class="input-group">
        <?= $this->Form->control('q', [
            'label' => false,
            'value' => $q,
            'placeholder' => 'タイトル・本文を検索',
            'class' => 'form-control',
            'required' => false,
        ]) ?>
        <?= $this->Form->button('検索', ['class' => 'btn btn-primary']) ?>
    </div>
<?= $this->Form->end() ?>

<?php $hasResults = is_iterable($tasks) && (is_countable($tasks) ? count($tasks) > 0 : !empty(iterator_to_array($tasks, false))); ?>

<?php if (!$hasResults): ?>
    <p>該当タスクが見つかりません</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>プロジェクト</th>
                <th>ステータス</th>
                <th>期限</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $this->Html->link(h($task->title), ['controller' => 'Tasks', 'action' => 'view', $task->id]) ?></td>
                    <td><?= h($task->project->name ?? '') ?></td>
                    <td><?= h($task->status) ?></td>
                    <td><?= h($task->due_date) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <nav>
        <ul class="pagination">
            <?= $this->Paginator->prev('« 前') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('次 »') ?>
        </ul>
    </nav>
<?php endif ?>
