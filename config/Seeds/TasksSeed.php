<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class TasksSeed extends AbstractSeed
{
    public function run(): void
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $plus3 = date('Y-m-d', strtotime('+3 days'));
        $plus10 = date('Y-m-d', strtotime('+10 days'));
        $plus30 = date('Y-m-d', strtotime('+30 days'));

        $data = [
            // Project 1 (id 1-8)
            ['id' => 1, 'project_id' => 1, 'title' => 'TOPページ ワイヤー作成',       'body' => '主要セクションのレイアウト案を作成', 'status' => 'todo',  'priority' => 'high',   'due_date' => $today,        'assigned_to' => 1, 'created_by' => 1],
            ['id' => 2, 'project_id' => 1, 'title' => 'コンテンツ移行リスト',          'body' => '旧サイトからの移行対象を一覧化',     'status' => 'todo',  'priority' => 'high',   'due_date' => $yesterday,    'assigned_to' => 2, 'created_by' => 1],
            ['id' => 3, 'project_id' => 1, 'title' => 'CMS 検討',                       'body' => 'Headless CMS 候補比較',              'status' => 'doing', 'priority' => 'medium', 'due_date' => $plus3,        'assigned_to' => 4, 'created_by' => 1],
            ['id' => 4, 'project_id' => 1, 'title' => 'デザインシステム整備',          'body' => 'コンポーネントカタログ作成',         'status' => 'todo',  'priority' => 'medium', 'due_date' => $plus10,       'assigned_to' => null, 'created_by' => 1],
            ['id' => 5, 'project_id' => 1, 'title' => '要件定義レビュー',              'body' => null,                                  'status' => 'done',  'priority' => 'medium', 'due_date' => '2026-01-15', 'assigned_to' => 1, 'created_by' => 1],
            ['id' => 6, 'project_id' => 1, 'title' => '画像素材の整理',                'body' => '商用利用可否確認',                    'status' => 'todo',  'priority' => 'low',    'due_date' => null,          'assigned_to' => 2, 'created_by' => 1],
            ['id' => 7, 'project_id' => 1, 'title' => '本番環境調査',                  'body' => 'スペック・移行計画',                  'status' => 'doing', 'priority' => 'low',    'due_date' => $tomorrow,     'assigned_to' => 1, 'created_by' => 1],
            ['id' => 8, 'project_id' => 1, 'title' => 'SEO 改善案',                    'body' => 'メタ・構造化データ',                  'status' => 'todo',  'priority' => 'low',    'due_date' => $plus30,       'assigned_to' => null, 'created_by' => 1],

            // Project 2 (id 9-16)
            ['id' => 9,  'project_id' => 2, 'title' => '研修カリキュラム素案',          'body' => '4週間プラン',                         'status' => 'todo',  'priority' => 'high',   'due_date' => $today,        'assigned_to' => 1, 'created_by' => 1],
            ['id' => 10, 'project_id' => 2, 'title' => '講師調整',                       'body' => '内部講師アサイン',                    'status' => 'todo',  'priority' => 'high',   'due_date' => $yesterday,    'assigned_to' => 3, 'created_by' => 1],
            ['id' => 11, 'project_id' => 2, 'title' => '会場手配',                       'body' => '研修ルーム予約',                      'status' => 'doing', 'priority' => 'medium', 'due_date' => $plus3,        'assigned_to' => 1, 'created_by' => 1],
            ['id' => 12, 'project_id' => 2, 'title' => '懇親会企画',                    'body' => null,                                  'status' => 'todo',  'priority' => 'medium', 'due_date' => $plus10,       'assigned_to' => null, 'created_by' => 1],
            ['id' => 13, 'project_id' => 2, 'title' => 'ロゴ確認',                       'body' => null,                                  'status' => 'done',  'priority' => 'medium', 'due_date' => '2025-12-15', 'assigned_to' => 3, 'created_by' => 1],
            ['id' => 14, 'project_id' => 2, 'title' => '案内メール文面',                'body' => '受講者向けと講師向け',                'status' => 'todo',  'priority' => 'low',    'due_date' => null,          'assigned_to' => 1, 'created_by' => 1],
            ['id' => 15, 'project_id' => 2, 'title' => 'アンケート設計',                'body' => null,                                  'status' => 'doing', 'priority' => 'low',    'due_date' => $tomorrow,     'assigned_to' => 3, 'created_by' => 1],
            ['id' => 16, 'project_id' => 2, 'title' => 'スケジュール最終確認',          'body' => null,                                  'status' => 'todo',  'priority' => 'low',    'due_date' => $plus30,       'assigned_to' => null, 'created_by' => 1],

            // Project 3 (id 17-24)
            ['id' => 17, 'project_id' => 3, 'title' => '脆弱性スキャン定例実行',         'body' => 'OWASP ZAP 月次',                       'status' => 'todo',  'priority' => 'high',   'due_date' => $today,        'assigned_to' => 2, 'created_by' => 2],
            ['id' => 18, 'project_id' => 3, 'title' => 'ペネトレ報告書レビュー',         'body' => '外部ベンダ報告のリスク評価',           'status' => 'todo',  'priority' => 'high',   'due_date' => $yesterday,    'assigned_to' => 3, 'created_by' => 2],
            ['id' => 19, 'project_id' => 3, 'title' => '依存パッケージ更新',             'body' => 'CVE 該当ライブラリ棚卸し',             'status' => 'doing', 'priority' => 'medium', 'due_date' => $plus3,        'assigned_to' => 2, 'created_by' => 2],
            ['id' => 20, 'project_id' => 3, 'title' => 'アクセスログ監査',               'body' => null,                                    'status' => 'todo',  'priority' => 'medium', 'due_date' => $plus10,       'assigned_to' => null, 'created_by' => 2],
            ['id' => 21, 'project_id' => 3, 'title' => 'IAMポリシー棚卸し',              'body' => null,                                    'status' => 'done',  'priority' => 'medium', 'due_date' => '2026-02-15', 'assigned_to' => 3, 'created_by' => 2],
            ['id' => 22, 'project_id' => 3, 'title' => 'インシデント訓練計画',           'body' => '半期に一度の訓練',                       'status' => 'todo',  'priority' => 'low',    'due_date' => null,          'assigned_to' => 2, 'created_by' => 2],
            ['id' => 23, 'project_id' => 3, 'title' => '侵入検知ルール見直し',           'body' => null,                                    'status' => 'doing', 'priority' => 'low',    'due_date' => $tomorrow,     'assigned_to' => 3, 'created_by' => 2],
            ['id' => 24, 'project_id' => 3, 'title' => 'セキュリティ研修資料更新',       'body' => null,                                    'status' => 'todo',  'priority' => 'low',    'due_date' => $plus30,       'assigned_to' => 2, 'created_by' => 2],
        ];

        $this->execute('TRUNCATE TABLE tasks RESTART IDENTITY CASCADE');
        $this->table('tasks')->insert($data)->saveData();
    }
}
