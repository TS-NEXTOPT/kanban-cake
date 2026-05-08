<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TasksTags Controller
 *
 * @property \App\Model\Table\TasksTagsTable $TasksTags
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class TasksTagsController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TasksTags->find()
            ->contain(['Tasks', 'Tags']);
        $query = $this->Authorization->applyScope($query);
        $tasksTags = $this->paginate($query);

        $this->set(compact('tasksTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Tasks Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tasksTag = $this->TasksTags->get($id, contain: ['Tasks', 'Tags']);
        $this->Authorization->authorize($tasksTag);
        $this->set(compact('tasksTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tasksTag = $this->TasksTags->newEmptyEntity();
        $this->Authorization->authorize($tasksTag);
        if ($this->request->is('post')) {
            $tasksTag = $this->TasksTags->patchEntity($tasksTag, $this->request->getData());
            if ($this->TasksTags->save($tasksTag)) {
                $this->Flash->success(__('The tasks tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tasks tag could not be saved. Please, try again.'));
        }
        $tasks = $this->TasksTags->Tasks->find('list', limit: 200)->all();
        $tags = $this->TasksTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('tasksTag', 'tasks', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tasks Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tasksTag = $this->TasksTags->get($id, contain: []);
        $this->Authorization->authorize($tasksTag);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tasksTag = $this->TasksTags->patchEntity($tasksTag, $this->request->getData());
            if ($this->TasksTags->save($tasksTag)) {
                $this->Flash->success(__('The tasks tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tasks tag could not be saved. Please, try again.'));
        }
        $tasks = $this->TasksTags->Tasks->find('list', limit: 200)->all();
        $tags = $this->TasksTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('tasksTag', 'tasks', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tasks Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tasksTag = $this->TasksTags->get($id);
        $this->Authorization->authorize($tasksTag);
        if ($this->TasksTags->delete($tasksTag)) {
            $this->Flash->success(__('The tasks tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tasks tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
