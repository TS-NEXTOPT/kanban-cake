<?php
declare(strict_types=1);
namespace App\Policy;
use App\Model\Entity\ProjectMember;
use App\Model\Entity\User;
class ProjectMemberPolicy {
    public function canIndex(User $user, ProjectMember $pm): bool { return true; }
    public function canView(User $user, ProjectMember $pm): bool { return true; }
    public function canAdd(User $user, ProjectMember $pm): bool { return true; }
    public function canEdit(User $user, ProjectMember $pm): bool { return true; }
    public function canDelete(User $user, ProjectMember $pm): bool { return true; }
}
