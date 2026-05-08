<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Project;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;

class ProjectPolicy
{
    public function canView(User $user, Project $project): bool
    {
        return $this->isMember($user, $project->id);
    }

    public function canEdit(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project->id);
    }

    public function canDelete(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project->id);
    }

    public function canAddMember(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project->id);
    }

    public function canRemoveMember(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project->id);
    }

    public function canAddTask(User $user, Project $project): bool
    {
        return $this->isMember($user, $project->id);
    }

    private function isMember(User $user, int $projectId): bool
    {
        $members = TableRegistry::getTableLocator()->get('ProjectMembers');
        return $members->exists(['project_id' => $projectId, 'user_id' => $user->id]);
    }

    private function isOwner(User $user, int $projectId): bool
    {
        $members = TableRegistry::getTableLocator()->get('ProjectMembers');
        return $members->exists([
            'project_id' => $projectId,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
    }
}
