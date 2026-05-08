<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagsTable Test Case
 */
class TagsTableTest extends TestCase
{
    protected TagsTable $Tags;

    protected array $fixtures = [
        'app.Tags',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tags') ? [] : ['className' => TagsTable::class];
        $this->Tags = $this->getTableLocator()->get('Tags', $config);
    }

    protected function tearDown(): void
    {
        unset($this->Tags);
        parent::tearDown();
    }

    public function testValidationDefault(): void
    {
        // name は必須
        $tag = $this->Tags->newEntity([]);
        $this->assertArrayHasKey('name', $tag->getErrors());

        // name は空不可
        $tag = $this->Tags->newEntity(['name' => '']);
        $this->assertArrayHasKey('name', $tag->getErrors());

        // name は100文字以下
        $tag = $this->Tags->newEntity(['name' => str_repeat('a', 101)]);
        $this->assertArrayHasKey('name', $tag->getErrors());

        // 正常ケース
        $tag = $this->Tags->newEntity(['name' => 'new-tag']);
        $this->assertEmpty($tag->getErrors());
    }

    public function testBuildRules(): void
    {
        // name の一意制約（'bug'はFixtureに既に存在）
        $tag = $this->Tags->newEntity(['name' => 'bug']);
        $result = $this->Tags->save($tag);
        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $tag->getErrors());
    }
}
