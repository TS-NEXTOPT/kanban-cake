<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTasksTags extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tasks_tags', ['id' => false, 'primary_key' => ['task_id', 'tag_id']]);
        $table
            ->addColumn('task_id', 'integer', ['null' => false])
            ->addColumn('tag_id', 'integer', ['null' => false])
            ->addForeignKey('task_id', 'tasks', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
