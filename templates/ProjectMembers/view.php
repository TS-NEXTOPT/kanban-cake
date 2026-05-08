<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectMember $projectMember
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Project Member'), ['action' => 'edit', $projectMember->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Project Member'), ['action' => 'delete', $projectMember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectMember->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Project Members'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Project Member'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="projectMembers view content">
            <h3><?= h($projectMember->role) ?></h3>
            <table>
                <tr>
                    <th><?= __('Project') ?></th>
                    <td><?= $projectMember->hasValue('project') ? $this->Html->link($projectMember->project->name, ['controller' => 'Projects', 'action' => 'view', $projectMember->project->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $projectMember->hasValue('user') ? $this->Html->link($projectMember->user->name, ['controller' => 'Users', 'action' => 'view', $projectMember->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($projectMember->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($projectMember->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($projectMember->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>