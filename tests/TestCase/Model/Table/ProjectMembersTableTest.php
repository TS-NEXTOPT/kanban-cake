<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectMembersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectMembersTable Test Case
 */
class ProjectMembersTableTest extends TestCase
{
    protected ProjectMembersTable $ProjectMembers;

    protected array $fixtures = [
        'app.Users',
        'app.Projects',
        'app.ProjectMembers',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProjectMembers') ? [] : ['className' => ProjectMembersTable::class];
        $this->ProjectMembers = $this->getTableLocator()->get('ProjectMembers', $config);
    }

    protected function tearDown(): void
    {
        unset($this->ProjectMembers);
        parent::tearDown();
    }

    public function testValidationDefault(): void
    {
        // role は必須
        $pm = $this->ProjectMembers->newEntity(['project_id' => 1, 'user_id' => 1, 'role' => '']);
        $this->assertArrayHasKey('role', $pm->getErrors());

        // role は20文字以下
        $pm = $this->ProjectMembers->newEntity(['project_id' => 1, 'user_id' => 1, 'role' => str_repeat('a', 21)]);
        $this->assertArrayHasKey('role', $pm->getErrors());

        // 正常ケース
        $pm = $this->ProjectMembers->newEntity(['project_id' => 1, 'user_id' => 1, 'role' => 'member']);
        $this->assertEmpty($pm->getErrors());
    }

    public function testBuildRules(): void
    {
        // 存在しないproject_idは保存失敗
        $pm = $this->ProjectMembers->newEntity(['project_id' => 9999, 'user_id' => 1, 'role' => 'member']);
        $result = $this->ProjectMembers->save($pm);
        $this->assertFalse($result);
        $this->assertArrayHasKey('project_id', $pm->getErrors());

        // 存在しないuser_idは保存失敗
        $pm = $this->ProjectMembers->newEntity(['project_id' => 1, 'user_id' => 9999, 'role' => 'member']);
        $result = $this->ProjectMembers->save($pm);
        $this->assertFalse($result);
        $this->assertArrayHasKey('user_id', $pm->getErrors());

        // project_id + user_id の重複は保存失敗（Fixtureでaliceはproject 1のowner）
        $pm = $this->ProjectMembers->newEntity(['project_id' => 1, 'user_id' => 1, 'role' => 'member']);
        $result = $this->ProjectMembers->save($pm);
        $this->assertFalse($result);
        $this->assertArrayHasKey('project_id', $pm->getErrors());
    }
}
