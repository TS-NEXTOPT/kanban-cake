<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class TasksTableTest extends TestCase
{
    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.ProjectMembers',
        'app.Tasks',
        'app.Comments',
        'app.Tags',
        'app.TasksTags',
    ];

    protected TasksTable $Tasks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Tasks = TableRegistry::getTableLocator()->get('Tasks');
    }

    public function testInitialization(): void
    {
        $this->assertInstanceOf(TasksTable::class, $this->Tasks);
        $this->assertSame('tasks', $this->Tasks->getTable());
    }

    public function testValidationDefault(): void
    {
        $task = $this->Tasks->newEntity([
            'project_id' => 1,
            'title' => '',
            'status' => 'todo',
            'priority' => 'medium',
            'created_by' => 1,
        ]);
        $this->assertNotEmpty($task->getErrors());
        $this->assertArrayHasKey('title', $task->getErrors());

        $task2 = $this->Tasks->newEntity([
            'project_id' => 1,
            'title' => 'OK',
            'status' => 'invalid',
            'priority' => 'medium',
            'created_by' => 1,
        ]);
        $this->assertArrayHasKey('status', $task2->getErrors());
    }

    public function testBelongsToProject(): void
    {
        $assoc = $this->Tasks->getAssociation('Projects');
        $this->assertInstanceOf(\Cake\ORM\Association\BelongsTo::class, $assoc);
    }

    public function testBelongsToManyTags(): void
    {
        $assoc = $this->Tasks->getAssociation('Tags');
        $this->assertInstanceOf(\Cake\ORM\Association\BelongsToMany::class, $assoc);
    }

    public function testHasManyComments(): void
    {
        $assoc = $this->Tasks->getAssociation('Comments');
        $this->assertInstanceOf(\Cake\ORM\Association\HasMany::class, $assoc);
    }
}
