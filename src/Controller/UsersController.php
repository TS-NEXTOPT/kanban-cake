<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register', 'logout']);
        $this->Authorization->skipAuthorization();
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Authentication->setIdentity($user);
                $this->Flash->success('登録が完了しました');
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
            }
            $this->Flash->error('登録に失敗しました');
        }
        $this->set(compact('user'));
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result?->isValid()) {
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Dashboard', 'action' => 'index']);
            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result?->isValid()) {
            $this->Flash->error('メールアドレスまたはパスワードが正しくありません');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }
}
