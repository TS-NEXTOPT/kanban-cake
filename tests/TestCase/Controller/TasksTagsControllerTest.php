<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TasksTagsController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TasksTagsController Test Case
 *
 * @link \App\Controller\TasksTagsController
 */
class TasksTagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.Tags',
        'app.Tasks',
        'app.TasksTags',
    ];

    private function loginAsAlice(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $user = new User(['id' => 1, 'email' => 'alice@example.com', 'name' => 'Alice']);
        $this->session(['Auth' => $user]);
    }

    public function testIndex(): void
    {
        $this->loginAsAlice();
        $this->get('/tasks-tags');
        $this->assertResponseOk();
    }

    // composite PKのview/edit/deleteはunauthで認証リダイレクトを確認
    public function testView(): void
    {
        $this->get('/tasks-tags/view/1');
        $this->assertRedirectContains('/users/login');
    }

    public function testAdd(): void
    {
        $this->loginAsAlice();
        $this->get('/tasks-tags/add');
        $this->assertResponseOk();
    }

    public function testEdit(): void
    {
        $this->get('/tasks-tags/edit/1');
        $this->assertRedirectContains('/users/login');
    }

    public function testDelete(): void
    {
        $this->get('/tasks-tags/delete/1');
        $this->assertRedirectContains('/users/login');
    }
}
