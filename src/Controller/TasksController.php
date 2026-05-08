<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Http\Exception\ForbiddenException;
use Cake\Mailer\Mailer;

class TasksController extends AppController
{
    public function add(int $projectId)
    {
        // 認可（手書き）
        $project = $this->fetchTable('Projects')->get($projectId, contain: ['ProjectMembers']);
        $isMember = false;
        foreach ($project->project_members as $m) {
            if ($m->user_id === $this->Authentication->getIdentity()->getIdentifier()) {
                $isMember = true;
                break;
            }
        }
        if (!$isMember) {
            throw new ForbiddenException();
        }

        $task = $this->Tasks->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['project_id'] = $projectId;
            $data['created_by'] = $this->Authentication->getIdentity()->getIdentifier();

            // タグ処理（インライン直書き）
            if (!empty($data['tag_names'])) {
                $names = explode(',', $data['tag_names']);
                $tags = [];
                foreach ($names as $name) {
                    $tags[] = ['name' => trim($name)];
                }
                $data['tags'] = $tags;
            }

            $task = $this->Tasks->patchEntity($task, $data, ['associated' => ['Tags']]);
            if ($this->Tasks->save($task, ['associated' => ['Tags']])) {
                // 通知メール（Mailer 直接呼出）
                if ($task->assigned_to) {
                    $assignee = $this->Tasks->Assignee->get($task->assigned_to);
                    $mailer = new Mailer('default');
                    $mailer->setTo($assignee->email)
                        ->setSubject('新しいタスクが割り当てられました')
                        ->deliver("タスク: {$task->title}\nプロジェクト: {$project->name}");
                }
                // 検索インデックス更新（直書き）
                Cache::delete("search_index_{$projectId}");
                $this->Flash->success('タスクを作成しました');
                return $this->redirect(['controller' => 'Projects', 'action' => 'view', $projectId]);
            }
            $this->Flash->error('タスクの作成に失敗しました');
        }

        $members = $this->fetchTable('Users')->find()
            ->matching('Memberships', fn($q) => $q->where(['Memberships.id' => $projectId]))
            ->all();
        $this->set(compact('task', 'project', 'members'));
    }

    public function view(int $id)
    {
        $task = $this->Tasks->get($id, contain: ['Projects', 'Assignee', 'Creator', 'Tags', 'Comments' => ['Users']]);
        $this->Authorization->authorize($task);
        $this->set(compact('task'));
    }

    public function edit(int $id)
    {
        $task = $this->Tasks->get($id, contain: ['Tags']);
        $this->Authorization->authorize($task);

        if ($this->request->is(['post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success('更新しました');
                return $this->redirect(['action' => 'view', $task->id]);
            }
            $this->Flash->error('更新に失敗しました');
        }
        $members = $this->fetchTable('Users')->find()
            ->matching('Memberships', fn($q) => $q->where(['Memberships.id' => $task->project_id]))
            ->all();
        $this->set(compact('task', 'members'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod('post');
        $task = $this->Tasks->get($id);
        $this->Authorization->authorize($task);
        $projectId = $task->project_id;
        if ($this->Tasks->delete($task)) {
            $this->Flash->success('削除しました');
        } else {
            $this->Flash->error('削除に失敗しました');
        }
        return $this->redirect(['controller' => 'Projects', 'action' => 'view', $projectId]);
    }
}
