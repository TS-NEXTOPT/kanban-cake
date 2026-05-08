<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
    ];

    public function testRegisterDisplaysForm(): void
    {
        $this->get('/users/register');
        $this->assertResponseOk();
        $this->assertResponseContains('新規登録');
    }

    public function testRegisterCreatesUser(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/users/register', [
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => 'password123',
        ]);
        $this->assertRedirect(['controller' => 'Dashboard', 'action' => 'index']);
        $users = $this->getTableLocator()->get('Users');
        $this->assertSame(1, $users->find()->where(['email' => 'bob@example.com'])->count());
    }

    public function testLoginSuccess(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/users/login', ['email' => 'alice@example.com', 'password' => 'password']);
        $this->assertRedirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

    public function testLoginFailure(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();
        $this->post('/users/login', ['email' => 'alice@example.com', 'password' => 'wrong']);
        $this->assertResponseOk();
        $this->assertFlashMessage('メールアドレスまたはパスワードが正しくありません');
    }

    public function testLogout(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->session(['Auth' => ['id' => 1, 'email' => 'alice@example.com', 'name' => 'Alice']]);
        $this->post('/users/logout');
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }
}
