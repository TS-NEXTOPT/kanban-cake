<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TasksTag $tasksTag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tasks Tag'), ['action' => 'edit', $tasksTag->task_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tasks Tag'), ['action' => 'delete', $tasksTag->task_id], ['confirm' => __('Are you sure you want to delete # {0}?', $tasksTag->task_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tasks Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tasks Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tasksTags view content">
            <h3><?= h($tasksTag->Array) ?></h3>
            <table>
                <tr>
                    <th><?= __('Task') ?></th>
                    <td><?= $tasksTag->hasValue('task') ? $this->Html->link($tasksTag->task->title, ['controller' => 'Tasks', 'action' => 'view', $tasksTag->task->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $tasksTag->hasValue('tag') ? $this->Html->link($tasksTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $tasksTag->tag->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>