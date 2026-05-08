<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProjectMembers Controller
 *
 * @property \App\Model\Table\ProjectMembersTable $ProjectMembers
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class ProjectMembersController extends AppController
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
        $query = $this->ProjectMembers->find()
            ->contain(['Projects', 'Users']);
        $query = $this->Authorization->applyScope($query);
        $projectMembers = $this->paginate($query);

        $this->set(compact('projectMembers'));
    }

    /**
     * View method
     *
     * @param string|null $id Project Member id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectMember = $this->ProjectMembers->get($id, contain: ['Projects', 'Users']);
        $this->Authorization->authorize($projectMember);
        $this->set(compact('projectMember'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectMember = $this->ProjectMembers->newEmptyEntity();
        $this->Authorization->authorize($projectMember);
        if ($this->request->is('post')) {
            $projectMember = $this->ProjectMembers->patchEntity($projectMember, $this->request->getData());
            if ($this->ProjectMembers->save($projectMember)) {
                $this->Flash->success(__('The project member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project member could not be saved. Please, try again.'));
        }
        $projects = $this->ProjectMembers->Projects->find('list', limit: 200)->all();
        $users = $this->ProjectMembers->Users->find('list', limit: 200)->all();
        $this->set(compact('projectMember', 'projects', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Member id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectMember = $this->ProjectMembers->get($id, contain: []);
        $this->Authorization->authorize($projectMember);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectMember = $this->ProjectMembers->patchEntity($projectMember, $this->request->getData());
            if ($this->ProjectMembers->save($projectMember)) {
                $this->Flash->success(__('The project member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project member could not be saved. Please, try again.'));
        }
        $projects = $this->ProjectMembers->Projects->find('list', limit: 200)->all();
        $users = $this->ProjectMembers->Users->find('list', limit: 200)->all();
        $this->set(compact('projectMember', 'projects', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Member id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectMember = $this->ProjectMembers->get($id);
        $this->Authorization->authorize($projectMember);
        if ($this->ProjectMembers->delete($projectMember)) {
            $this->Flash->success(__('The project member has been deleted.'));
        } else {
            $this->Flash->error(__('The project member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
