<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectsTable Test Case
 */
class ProjectsTableTest extends TestCase
{
    protected ProjectsTable $Projects;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Projects') ? [] : ['className' => ProjectsTable::class];
        $this->Projects = $this->getTableLocator()->get('Projects', $config);
    }

    protected function tearDown(): void
    {
        unset($this->Projects);
        parent::tearDown();
    }

    public function testValidationDefault(): void
    {
        // name は必須
        $project = $this->Projects->newEntity(['created_by' => 1]);
        $this->assertArrayHasKey('name', $project->getErrors());

        // name は空不可
        $project = $this->Projects->newEntity(['name' => '', 'created_by' => 1]);
        $this->assertArrayHasKey('name', $project->getErrors());

        // created_by は必須
        $project = $this->Projects->newEntity(['name' => 'My Project']);
        $this->assertArrayHasKey('created_by', $project->getErrors());

        // 正常ケース
        $project = $this->Projects->newEntity(['name' => 'New Project', 'created_by' => 1]);
        $this->assertEmpty($project->getErrors());
    }
}
