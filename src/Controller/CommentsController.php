<?php
declare(strict_types=1);

namespace App\Controller;

class CommentsController extends AppController
{
    public function add(int $taskId)
    {
        $this->request->allowMethod('post');
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $comment = $this->Comments->newEntity([
            'task_id' => $taskId,
            'user_id' => $userId,
            'body' => $this->request->getData('body'),
        ]);
        $this->Authorization->authorize($comment, 'add');

        if ($this->Comments->save($comment)) {
            $this->Flash->success('コメントを投稿しました');
        } else {
            $this->Flash->error('投稿に失敗しました');
        }
        return $this->redirect(['controller' => 'Tasks', 'action' => 'view', $taskId]);
    }

    public function delete(int $id)
    {
        $this->request->allowMethod('post');
        $comment = $this->Comments->get($id);
        $this->Authorization->authorize($comment);
        $taskId = $comment->task_id;
        if ($this->Comments->delete($comment)) {
            $this->Flash->success('削除しました');
        } else {
            $this->Flash->error('削除に失敗しました');
        }
        return $this->redirect(['controller' => 'Tasks', 'action' => 'view', $taskId]);
    }
}
