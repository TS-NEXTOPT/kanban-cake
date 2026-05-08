<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tasks');
        $table
            ->addColumn('project_id', 'integer', ['null' => false])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('body', 'text', ['null' => true])
            ->addColumn('status', 'string', ['limit' => 20, 'null' => false, 'default' => 'todo'])
            ->addColumn('priority', 'string', ['limit' => 20, 'null' => true, 'default' => 'medium'])
            ->addColumn('due_date', 'date', ['null' => true])
            ->addColumn('assigned_to', 'integer', ['null' => true])
            ->addColumn('created_by', 'integer', ['null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('project_id', 'projects', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('assigned_to', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('created_by', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
            ->create();
    }
}
