<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class TasksTagsSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['task_id' => 1,  'tag_id' => 1], ['task_id' => 1,  'tag_id' => 4],
            ['task_id' => 2,  'tag_id' => 6],
            ['task_id' => 3,  'tag_id' => 10], ['task_id' => 3, 'tag_id' => 3],
            ['task_id' => 4,  'tag_id' => 4], ['task_id' => 4, 'tag_id' => 9],
            ['task_id' => 5,  'tag_id' => 5],
            ['task_id' => 7,  'tag_id' => 8],
            ['task_id' => 8,  'tag_id' => 3], ['task_id' => 8, 'tag_id' => 6],
            ['task_id' => 9,  'tag_id' => 3], ['task_id' => 9, 'tag_id' => 4],
            ['task_id' => 10, 'tag_id' => 1],
            ['task_id' => 11, 'tag_id' => 8],
            ['task_id' => 13, 'tag_id' => 4],
            ['task_id' => 15, 'tag_id' => 6],
            ['task_id' => 17, 'tag_id' => 1], ['task_id' => 17, 'tag_id' => 7],
            ['task_id' => 18, 'tag_id' => 5], ['task_id' => 18, 'tag_id' => 2],
            ['task_id' => 19, 'tag_id' => 2], ['task_id' => 19, 'tag_id' => 1],
            ['task_id' => 21, 'tag_id' => 8],
            ['task_id' => 23, 'tag_id' => 8], ['task_id' => 23, 'tag_id' => 7],
            ['task_id' => 24, 'tag_id' => 6],
        ];

        $this->execute('TRUNCATE TABLE tasks_tags CASCADE');
        $this->table('tasks_tags')->insert($data)->saveData();
    }
}
