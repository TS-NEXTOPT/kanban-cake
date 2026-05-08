<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Task;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;

class TaskPolicy
{
    public function canView(User $user, Task $task): bool
    {
        return $this->isProjectMember($user, $task->project_id);
    }

    public function canEdit(User $user, Task $task): bool
    {
        // バグ: ログイン中なら誰でも true を返してしまう（プロジェクトメンバーシップを確認していない）
        return $user !== null;
    }

    public function canDelete(User $user, Task $task): bool
    {
        return $this->isProjectMember($user, $task->project_id);
    }

    private function isProjectMember(User $user, int $projectId): bool
    {
        $members = TableRegistry::getTableLocator()->get('ProjectMembers');
        return $members->exists(['project_id' => $projectId, 'user_id' => $user->id]);
    }
}
