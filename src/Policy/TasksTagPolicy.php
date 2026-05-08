<?php
declare(strict_types=1);
namespace App\Policy;
use App\Model\Entity\TasksTag;
use App\Model\Entity\User;
class TasksTagPolicy {
    public function canIndex(User $user, TasksTag $tt): bool { return true; }
    public function canView(User $user, TasksTag $tt): bool { return true; }
    public function canAdd(User $user, TasksTag $tt): bool { return true; }
    public function canEdit(User $user, TasksTag $tt): bool { return true; }
    public function canDelete(User $user, TasksTag $tt): bool { return true; }
}
