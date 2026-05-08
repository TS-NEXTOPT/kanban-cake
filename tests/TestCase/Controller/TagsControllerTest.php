<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TagsController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TagsController Test Case
 *
 * @link \App\Controller\TagsController
 */
class TagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.Tags',
        'app.Tasks',
        'app.TasksTags',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $user = new User(['id' => 1, 'email' => 'alice@example.com', 'name' => 'Alice']);
        $this->session(['Auth' => $user]);
    }

    public function testIndex(): void
    {
        $this->get('/tags');
        $this->assertResponseOk();
    }

    public function testView(): void
    {
        $this->get('/tags/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('bug');
    }

    public function testAdd(): void
    {
        $this->post('/tags/add', ['name' => 'New Tag']);
        $this->assertRedirectContains('/tags');
    }

    public function testEdit(): void
    {
        $this->post('/tags/edit/1', ['name' => 'Updated Bug']);
        $this->assertRedirectContains('/tags');
    }

    public function testDelete(): void
    {
        $this->post('/tags/delete/1');
        $this->assertRedirect('/tags');
    }
}
