<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProjectMember> $projectMembers
 */
?>
<div class="projectMembers index content">
    <?= $this->Html->link(__('New Project Member'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Project Members') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('project_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projectMembers as $projectMember): ?>
                <tr>
                    <td><?= $this->Number->format($projectMember->id) ?></td>
                    <td><?= $projectMember->hasValue('project') ? $this->Html->link($projectMember->project->name, ['controller' => 'Projects', 'action' => 'view', $projectMember->project->id]) : '' ?></td>
                    <td><?= $projectMember->hasValue('user') ? $this->Html->link($projectMember->user->name, ['controller' => 'Users', 'action' => 'view', $projectMember->user->id]) : '' ?></td>
                    <td><?= h($projectMember->role) ?></td>
                    <td><?= h($projectMember->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $projectMember->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectMember->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $projectMember->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $projectMember->id),
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