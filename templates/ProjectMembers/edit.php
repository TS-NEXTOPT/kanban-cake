<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectMember $projectMember
 * @var string[]|\Cake\Collection\CollectionInterface $projects
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $projectMember->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectMember->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Project Members'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="projectMembers form content">
            <?= $this->Form->create($projectMember) ?>
            <fieldset>
                <legend><?= __('Edit Project Member') ?></legend>
                <?php
                    echo $this->Form->control('project_id', ['options' => $projects]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('role');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
