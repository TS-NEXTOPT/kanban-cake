<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommentsTable Test Case
 */
class CommentsTableTest extends TestCase
{
    protected CommentsTable $Comments;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.Tasks',
        'app.Comments',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Comments') ? [] : ['className' => CommentsTable::class];
        $this->Comments = $this->getTableLocator()->get('Comments', $config);
    }

    protected function tearDown(): void
    {
        unset($this->Comments);
        parent::tearDown();
    }

    public function testValidationDefault(): void
    {
        // task_id は必須
        $comment = $this->Comments->newEntity(['user_id' => 1, 'body' => 'hello']);
        $this->assertArrayHasKey('task_id', $comment->getErrors());

        // body は必須
        $comment = $this->Comments->newEntity(['task_id' => 1, 'user_id' => 1]);
        $this->assertArrayHasKey('body', $comment->getErrors());

        // body は空不可
        $comment = $this->Comments->newEntity(['task_id' => 1, 'user_id' => 1, 'body' => '']);
        $this->assertArrayHasKey('body', $comment->getErrors());

        // 正常ケース
        $comment = $this->Comments->newEntity(['task_id' => 1, 'user_id' => 1, 'body' => 'Great work!']);
        $this->assertEmpty($comment->getErrors());
    }

    public function testBuildRules(): void
    {
        $comment = $this->Comments->newEntity(['task_id' => 9999, 'user_id' => 1, 'body' => 'hello']);
        $result = $this->Comments->save($comment);
        $this->assertFalse($result);
        $this->assertArrayHasKey('task_id', $comment->getErrors());

        $comment = $this->Comments->newEntity(['task_id' => 1, 'user_id' => 9999, 'body' => 'hello']);
        $result = $this->Comments->save($comment);
        $this->assertFalse($result);
        $this->assertArrayHasKey('user_id', $comment->getErrors());
    }
}
