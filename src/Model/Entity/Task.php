<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

class Task extends Entity
{
    protected array $_accessible = [
        'project_id' => true,
        'title' => true,
        'body' => true,
        'status' => true,
        'priority' => true,
        'due_date' => true,
        'assigned_to' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'tags' => true,
        'tag_names' => true,
        'project' => true,
        'assignee' => true,
        'creator' => true,
        'comments' => true,
    ];

    protected array $_virtual = ['is_overdue'];

    protected function _getIsOverdue(): bool
    {
        if ($this->due_date === null || $this->status === 'done') {
            return false;
        }
        // バグ: <= になっている。本来は <
        return $this->due_date <= new \Cake\I18n\Date();
    }
}
