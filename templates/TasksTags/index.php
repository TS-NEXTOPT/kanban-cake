<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TasksTag> $tasksTags
 */
?>
<div class="tasksTags index content">
    <?= $this->Html->link(__('New Tasks Tag'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tasks Tags') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('task_id') ?></th>
                    <th><?= $this->Paginator->sort('tag_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasksTags as $tasksTag): ?>
                <tr>
                    <td><?= $tasksTag->hasValue('task') ? $this->Html->link($tasksTag->task->title, ['controller' => 'Tasks', 'action' => 'view', $tasksTag->task->id]) : '' ?></td>
                    <td><?= $tasksTag->hasValue('tag') ? $this->Html->link($tasksTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $tasksTag->tag->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tasksTag->task_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tasksTag->task_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $tasksTag->task_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $tasksTag->task_id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>