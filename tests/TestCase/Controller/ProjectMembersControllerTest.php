<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProjectMembersController;
use App\Model\Entity\User;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProjectMembersController Test Case
 *
 * @link \App\Controller\ProjectMembersController
 */
class ProjectMembersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.ProjectMembers',
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
        $this->get('/project-members');
        $this->assertResponseOk();
    }

    public function testView(): void
    {
        $this->get('/project-members/view/1');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->get('/project-members/add');
        $this->assertResponseOk();
    }

    public function testEdit(): void
    {
        $this->get('/project-members/edit/1');
        $this->assertResponseOk();
    }

    public function testDelete(): void
    {
        $this->post('/project-members/delete/1');
        $this->assertRedirect('/project-members');
    }
}
