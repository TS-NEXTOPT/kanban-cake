<?php
declare(strict_types=1);

namespace App\Controller;

class SearchController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $q = trim((string)$this->request->getQuery('q', ''));

        $projectIds = $this->fetchTable('ProjectMembers')->find()
            ->where(['user_id' => $userId])
            ->all()
            ->extract('project_id')
            ->toArray();

        if (empty($projectIds)) {
            $this->set(['tasks' => [], 'q' => $q]);
            return;
        }

        $tasksTable = $this->fetchTable('Tasks');
        $query = $tasksTable->find()
            ->where(['Tasks.project_id IN' => $projectIds])
            ->contain(['Projects'])
            ->orderBy(['Tasks.modified' => 'DESC']);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Tasks.title ILIKE' => '%' . $q . '%',
                    'Tasks.body ILIKE' => '%' . $q . '%',
                ],
            ]);
        }

        $tasks = $this->paginate($query, ['limit' => 20]);
        $this->set(compact('tasks', 'q'));
    }
}
