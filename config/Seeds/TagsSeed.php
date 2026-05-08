<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class TagsSeed extends AbstractSeed
{
    public function run(): void
    {
        $names = ['urgent', 'bug', 'feature', 'design', 'review', 'doc', 'test', 'infra', 'ux', 'research'];
        $data = [];
        foreach ($names as $i => $name) {
            $data[] = ['id' => $i + 1, 'name' => $name];
        }

        $this->execute('TRUNCATE TABLE tags RESTART IDENTITY CASCADE');
        $this->table('tags')->insert($data)->saveData();
    }
}
