<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class ProjectsSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Webサイトリニューアル', 'description' => 'コーポレート刷新',     'created_by' => 1],
            ['id' => 2, 'name' => '新人研修プログラム',     'description' => '2026年度新人向け',     'created_by' => 1],
            ['id' => 3, 'name' => 'セキュリティ監査',         'description' => '年次脆弱性レビュー',   'created_by' => 2],
        ];

        $this->execute('TRUNCATE TABLE projects RESTART IDENTITY CASCADE');
        $this->table('projects')->insert($data)->saveData();
    }
}
