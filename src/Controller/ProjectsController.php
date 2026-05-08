<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ProjectsController extends AppController
{
    public function index()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $projects = $this->Projects->find()
            ->matching('Members', fn($q) => $q->where(['Members.id' => $userId]))
            ->orderBy(['Projects.created' => 'DESC']);
        $this->set('projects', $this->paginate($projects));
        $this->Authorization->skipAuthorization();
    }

    public function view(int $id)
    {
        $project = $this->Projects->get($id, contain: [
            'Members',
            'Creator',
            'Tasks' => ['Assignee', 'Tags'],
        ]);
        $this->Authorization->authorize($project);

        // タスク統計（直書き）
        $stats = ['todo' => 0, 'doing' => 0, 'done' => 0];
        foreach ($project->tasks as $t) {
            if (isset($stats[$t->status])) {
                $stats[$t->status]++;
            }
        }

        // 最近コメント（マジックナンバー = 5、直書き）
        $recentComments = $this->Projects->Tasks->Comments->find()
            ->contain(['Tasks', 'Users'])
            ->matching('Tasks', fn($q) => $q->where(['Tasks.project_id' => $id]))
            ->orderBy(['Comments.created' => 'DESC'])
            ->limit(5)
            ->toArray();

        $tasks = $project->tasks;

        $this->set(compact('project', 'stats', 'recentComments', 'tasks'));
    }

    public function add()
    {
        $project = $this->Projects->newEmptyEntity();
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $userId = $this->Authentication->getIdentity()->getIdentifier();
            $project = $this->Projects->patchEntity($project, [
                ...$this->request->getData(),
                'created_by' => $userId,
            ]);
            if ($this->Projects->save($project)) {
                $pm = $this->Projects->ProjectMembers->newEntity([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'role' => 'owner',
                ]);
                $this->Projects->ProjectMembers->save($pm);

                $this->Flash->success('プロジェクトを作成しました');
                return $this->redirect(['action' => 'view', $project->id]);
            }
            $this->Flash->error('作成に失敗しました');
        }
        $this->set(compact('project'));
    }

    public function edit(int $id)
    {
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);

        if ($this->request->is(['post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->getData());
            if ($this->Projects->save($project)) {
                $this->Flash->success('更新しました');
                return $this->redirect(['action' => 'view', $project->id]);
            }
            $this->Flash->error('更新に失敗しました');
        }
        $this->set(compact('project'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod('post');
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);
        if ($this->Projects->delete($project)) {
            $this->Flash->success('削除しました');
        } else {
            $this->Flash->error('削除に失敗しました');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function addMember(int $id)
    {
        $this->request->allowMethod('post');
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project, 'addMember');

        $email = $this->request->getData('email');
        $user = $this->Projects->Members->find()->where(['email' => $email])->first();
        if (!$user) {
            $this->Flash->error('該当ユーザが見つかりません');
            return $this->redirect(['action' => 'view', $id]);
        }
        $pm = $this->Projects->ProjectMembers->newEntity([
            'project_id' => $id,
            'user_id' => $user->id,
            'role' => 'member',
        ]);
        if ($this->Projects->ProjectMembers->save($pm)) {
            $this->Flash->success('メンバーを追加しました');
        } else {
            $this->Flash->error('既にメンバーです、または追加に失敗しました');
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    public function removeMember(int $id, int $userId)
    {
        $this->request->allowMethod('post');
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project, 'removeMember');

        $pm = $this->Projects->ProjectMembers->find()
            ->where(['project_id' => $id, 'user_id' => $userId])
            ->first();
        if (!$pm) {
            throw new NotFoundException();
        }
        if ($pm->role === 'owner' && $pm->user_id === $this->Authentication->getIdentity()->getIdentifier()) {
            $this->Flash->error('オーナー自身は削除できません');
            return $this->redirect(['action' => 'view', $id]);
        }
        if ($this->Projects->ProjectMembers->delete($pm)) {
            $this->Flash->success('メンバーを削除しました');
        } else {
            $this->Flash->error('削除に失敗しました');
        }
        return $this->redirect(['action' => 'view', $id]);
    }
}
