<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class ProjectMembersSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['UsersSeed', 'ProjectsSeed'];
    }

    public function run(): void
    {
        // alice は project 3 に所属しない
        $data = [
            ['project_id' => 1, 'user_id' => 1, 'role' => 'owner'],
            ['project_id' => 1, 'user_id' => 2, 'role' => 'member'],
            ['project_id' => 1, 'user_id' => 4, 'role' => 'member'],
            ['project_id' => 2, 'user_id' => 1, 'role' => 'owner'],
            ['project_id' => 2, 'user_id' => 3, 'role' => 'member'],
            ['project_id' => 3, 'user_id' => 2, 'role' => 'owner'],
            ['project_id' => 3, 'user_id' => 3, 'role' => 'member'],
        ];

        $this->execute('TRUNCATE TABLE project_members RESTART IDENTITY CASCADE');
        $this->table('project_members')->insert($data)->saveData();
    }
}
