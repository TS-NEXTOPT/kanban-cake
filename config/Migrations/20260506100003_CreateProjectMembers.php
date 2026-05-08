<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProjectMembers extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('project_members');
        $table
            ->addColumn('project_id', 'integer', ['null' => false])
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('role', 'string', ['limit' => 20, 'null' => false, 'default' => 'member'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('project_id', 'projects', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addIndex(['project_id', 'user_id'], ['unique' => true])
            ->create();
    }
}
