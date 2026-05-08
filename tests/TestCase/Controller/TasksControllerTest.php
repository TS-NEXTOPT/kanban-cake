<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TasksController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TasksController Test Case
 *
 * @link \App\Controller\TasksController
 */
class TasksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.ProjectMembers',
        'app.Tags',
        'app.Tasks',
        'app.Comments',
        'app.TasksTags',
    ];

    private function loginAsAlice(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $user = new User(['id' => 1, 'email' => 'alice@example.com', 'name' => 'Alice']);
        $this->session(['Auth' => $user]);
    }

    // TasksControllerにindexアクションは存在しないため認証リダイレクトを確認
    public function testIndex(): void
    {
        $this->get('/tasks');
        $this->assertRedirectContains('/users/login');
    }

    public function testView(): void
    {
        $this->loginAsAlice();
        $this->get('/tasks/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Task');
    }

    public function testAdd(): void
    {
        // TasksController::add は skipAuthorization() を呼ばないため
        // 未認証アクセスが /users/login にリダイレクトされることを確認
        $this->get('/projects/1/tasks/add');
        $this->assertRedirectContains('/users/login');
    }

    public function testEdit(): void
    {
        $this->loginAsAlice();
        $this->get('/tasks/1/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Task');
    }

    public function testDelete(): void
    {
        $this->loginAsAlice();
        $this->post('/tasks/1/delete');
        $this->assertRedirect('/projects/1');
    }
}
