<?php
declare(strict_types=1);
namespace App\Policy;
use App\Model\Entity\Tag;
use App\Model\Entity\User;
class TagPolicy {
    public function canIndex(User $user, Tag $tag): bool { return true; }
    public function canView(User $user, Tag $tag): bool { return true; }
    public function canAdd(User $user, Tag $tag): bool { return true; }
    public function canEdit(User $user, Tag $tag): bool { return true; }
    public function canDelete(User $user, Tag $tag): bool { return true; }
}
