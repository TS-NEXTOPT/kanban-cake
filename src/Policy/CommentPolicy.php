<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Comment;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;

class CommentPolicy
{
    public function canAdd(User $user, Comment $comment): bool
    {
        $tasks = TableRegistry::getTableLocator()->get('Tasks');
        $task = $tasks->get($comment->task_id);
        $members = TableRegistry::getTableLocator()->get('ProjectMembers');
        return $members->exists(['project_id' => $task->project_id, 'user_id' => $user->id]);
    }

    public function canDelete(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }
}
