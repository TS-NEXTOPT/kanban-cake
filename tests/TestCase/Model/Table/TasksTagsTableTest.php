<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TasksTagsTable Test Case
 */
class TasksTagsTableTest extends TestCase
{
    protected TasksTagsTable $TasksTags;

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
        $config = $this->getTableLocator()->exists('TasksTags') ? [] : ['className' => TasksTagsTable::class];
        $this->TasksTags = $this->getTableLocator()->get('TasksTags', $config);
    }

    protected function tearDown(): void
    {
        unset($this->TasksTags);
        parent::tearDown();
    }

    public function testBuildRules(): void
    {
        // 存在しないtask_idは保存失敗
        $tt = $this->TasksTags->newEntity(['task_id' => 9999, 'tag_id' => 1]);
        $result = $this->TasksTags->save($tt);
        $this->assertFalse($result);
        $this->assertArrayHasKey('task_id', $tt->getErrors());

        // 存在しないtag_idは保存失敗
        $tt = $this->TasksTags->newEntity(['task_id' => 1, 'tag_id' => 9999]);
        $result = $this->TasksTags->save($tt);
        $this->assertFalse($result);
        $this->assertArrayHasKey('tag_id', $tt->getErrors());
    }
}
