<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProjectsController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProjectsController Test Case
 *
 * @link \App\Controller\ProjectsController
 */
class ProjectsControllerTest extends TestCase
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
        $this->get('/projects');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Project');
    }

    public function testView(): void
    {
        $this->get('/projects/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Project');
    }

    public function testAdd(): void
    {
        $this->post('/projects/add', ['name' => 'New Project', 'description' => 'desc']);
        $this->assertRedirectContains('/projects/');
    }

    public function testEdit(): void
    {
        $this->post('/projects/1/edit', ['name' => 'Updated Project']);
        $this->assertRedirect('/projects/1');
    }

    public function testDelete(): void
    {
        $this->post('/projects/1/delete');
        $this->assertRedirect('/projects');
    }
}
