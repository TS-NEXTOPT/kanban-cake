<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class DatabaseSeed extends AbstractSeed
{
    public function run(): void
    {
        $this->call('UsersSeed');
        $this->call('ProjectsSeed');
        $this->call('ProjectMembersSeed');
        $this->call('TagsSeed');
        $this->call('TasksSeed');
        $this->call('CommentsSeed');
        $this->call('TasksTagsSeed');
    }
}
