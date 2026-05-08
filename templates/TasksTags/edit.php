<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TasksTag $tasksTag
 * @var string[]|\Cake\Collection\CollectionInterface $tasks
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tasksTag->task_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tasksTag->task_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tasks Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tasksTags form content">
            <?= $this->Form->create($tasksTag) ?>
            <fieldset>
                <legend><?= __('Edit Tasks Tag') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
