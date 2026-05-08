<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class CommentsSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['TasksSeed', 'UsersSeed'];
    }

    public function run(): void
    {
        $data = [
            ['task_id' => 1,  'user_id' => 1, 'body' => '進捗50%です'],
            ['task_id' => 1,  'user_id' => 2, 'body' => '明日までに片付けます'],
            ['task_id' => 2,  'user_id' => 2, 'body' => '一覧の雛形を共有しました'],
            ['task_id' => 3,  'user_id' => 4, 'body' => 'CMS A は要件外でした'],
            ['task_id' => 5,  'user_id' => 1, 'body' => 'レビュー完了'],
            ['task_id' => 7,  'user_id' => 1, 'body' => 'AWS 見積もり中'],
            ['task_id' => 9,  'user_id' => 1, 'body' => 'たたきを共有'],
            ['task_id' => 9,  'user_id' => 3, 'body' => '内容確認しました'],
            ['task_id' => 10, 'user_id' => 3, 'body' => '講師候補3名に打診'],
            ['task_id' => 11, 'user_id' => 1, 'body' => '会場予約済み'],
            ['task_id' => 13, 'user_id' => 3, 'body' => 'ロゴ確認OK'],
            ['task_id' => 15, 'user_id' => 3, 'body' => '質問項目たたき'],
            ['task_id' => 17, 'user_id' => 2, 'body' => '本日実行予定'],
            ['task_id' => 17, 'user_id' => 3, 'body' => '結果共有お願いします'],
            ['task_id' => 18, 'user_id' => 3, 'body' => '指摘事項3件あり'],
            ['task_id' => 19, 'user_id' => 2, 'body' => 'CVE-2025-XXXX 該当'],
            ['task_id' => 21, 'user_id' => 3, 'body' => '不要権限を整理'],
            ['task_id' => 23, 'user_id' => 3, 'body' => 'ルール案を作成'],
        ];

        $this->execute('TRUNCATE TABLE comments RESTART IDENTITY CASCADE');
        $this->table('comments')->insert($data)->saveData();
    }
}
