<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        // 自分担当タスク（todo/doing）
        $tasksTable = $this->fetchTable('Tasks');
        $myTasks = $tasksTable->find()
            ->where(['assigned_to' => $userId, 'status IN' => ['todo', 'doing']])
            ->contain(['Projects', 'Tags'])
            ->orderBy(['due_date' => 'ASC'])
            ->all();

        // タスクごとにコメント数を取得
        foreach ($myTasks as $task) {
            $task->comment_count = $this->fetchTable('Comments')
                ->find()
                ->where(['task_id' => $task->id])
                ->count();
        }

        // 期限が近いタスク（3日以内）
        $today = new \Cake\I18n\Date();
        $threeDaysLater = $today->modify('+3 days');
        $upcomingTasks = $tasksTable->find()
            ->where([
                'assigned_to' => $userId,
                'status IN' => ['todo', 'doing'],
                'due_date >=' => $today,
                'due_date <=' => $threeDaysLater,
            ])
            ->contain(['Projects'])
            ->orderBy(['due_date' => 'ASC'])
            ->all();

        // 参加プロジェクト一覧
        $projectsTable = $this->fetchTable('Projects');
        $myProjects = $projectsTable->find()
            ->matching('ProjectMembers', fn($q) => $q->where(['ProjectMembers.user_id' => $userId]))
            ->contain(['ProjectMembers'])
            ->all();

        // ステータス別カウント
        $todoCount = 0;
        $doingCount = 0;
        $doneCount = 0;
        foreach ($tasksTable->find()->where(['assigned_to' => $userId])->all() as $t) {
            if ($t->status === 'todo') {
                $todoCount++;
            } elseif ($t->status === 'doing') {
                $doingCount++;
            } elseif ($t->status === 'done') {
                $doneCount++;
            }
        }

        $this->set(compact('myTasks', 'upcomingTasks', 'myProjects', 'todoCount', 'doingCount', 'doneCount'));
    }
}
