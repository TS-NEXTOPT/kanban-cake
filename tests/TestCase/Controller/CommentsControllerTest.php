<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CommentsController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CommentsController Test Case
 *
 * @link \App\Controller\CommentsController
 */
class CommentsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.ProjectMembers',
        'app.Tasks',
        'app.Comments',
    ];

    private function loginAsAlice(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $user = new User(['id' => 1, 'email' => 'alice@example.com', 'name' => 'Alice']);
        $this->session(['Auth' => $user]);
    }

    // CommentsControllerにindexアクションは存在しないため認証リダイレクトを確認
    public function testIndex(): void
    {
        $this->get('/comments');
        $this->assertRedirectContains('/users/login');
    }

    // CommentsControllerにviewアクションは存在しないため認証リダイレクトを確認
    public function testView(): void
    {
        $this->get('/comments/view/1');
        $this->assertRedirectContains('/users/login');
    }

    public function testAdd(): void
    {
        $this->loginAsAlice();
        $this->post('/tasks/1/comments', ['body' => 'New comment']);
        $this->assertRedirectContains('/tasks/1');
    }

    // CommentsControllerにeditアクションは存在しないため認証リダイレクトを確認
    public function testEdit(): void
    {
        $this->get('/comments/edit/1');
        $this->assertRedirectContains('/users/login');
    }

    public function testDelete(): void
    {
        $this->loginAsAlice();
        $this->post('/comments/1/delete');
        $this->assertRedirectContains('/tasks/1');
    }
}
