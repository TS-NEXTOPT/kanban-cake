<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $myTasks
 * @var iterable $upcomingTasks
 * @var iterable $myProjects
 * @var int $todoCount
 * @var int $doingCount
 * @var int $doneCount
 */
?>
<h1>ダッシュボード</h1>

<section class="mb-4">
    <h2>ステータスサマリ</h2>
    <ul>
        <li>todo: <?= h($todoCount) ?></li>
        <li>doing: <?= h($doingCount) ?></li>
        <li>done: <?= h($doneCount) ?></li>
    </ul>
</section>

<section class="mb-4">
    <h2>自分担当タスク</h2>
    <?php if (count($myTasks) === 0): ?>
        <p>担当タスクなし</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>タイトル</th>
                    <th>プロジェクト</th>
                    <th>ステータス</th>
                    <th>期限</th>
                    <th>コメント数</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myTasks as $task): ?>
                    <tr>
                        <td><?= $this->Html->link(h($task->title), ['controller' => 'Tasks', 'action' => 'view', $task->id]) ?></td>
                        <td><?= h($task->project->name ?? '') ?></td>
                        <td><?= h($task->status) ?></td>
                        <td><?= h($task->due_date) ?></td>
                        <td><?= h($task->comment_count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</section>

<section class="mb-4">
    <h2>期限が近いタスク（3日以内）</h2>
    <?php if (count($upcomingTasks) === 0): ?>
        <p>該当なし</p>
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
                <?php foreach ($upcomingTasks as $task): ?>
                    <tr>
                        <td><?= $this->Html->link(h($task->title), ['controller' => 'Tasks', 'action' => 'view', $task->id]) ?></td>
                        <td><?= h($task->project->name ?? '') ?></td>
                        <td><?= h($task->status) ?></td>
                        <td><?= h($task->due_date) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</section>

<section>
    <h2>参加プロジェクト</h2>
    <?php if (count($myProjects) === 0): ?>
        <p>参加プロジェクトなし</p>
    <?php else: ?>
        <ul>
            <?php foreach ($myProjects as $p): ?>
                <li><?= $this->Html->link(h($p->name), ['controller' => 'Projects', 'action' => 'view', $p->id]) ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</section>
