# KanbanCake

社内向け簡易プロジェクト・タスク管理ツール。CakePHP 5.x ベース。

ユーザー登録・プロジェクト管理・タスク管理・コメント・タグ・検索を備えた一般的な Web アプリケーション。

---

## 機能

### 認証
- メールアドレス＋パスワードで新規登録
- ログイン / ログアウト

### プロジェクト
- 作成、編集、削除
- メンバー招待（登録済みユーザのメールアドレス指定）
- ロール：owner（編集・削除権あり）、member

### タスク
- プロジェクト配下にタスクを作成
- ステータス：todo / doing / done
- 優先度：low / medium / high
- 期限日、担当者を設定可能
- タグを複数付与可能

### コメント
- タスクへのコメント投稿
- 投稿者本人のみ削除可

### ダッシュボード
- 自分担当のタスク
- 期限が近いタスク
- 自分が参加しているプロジェクト

### 検索
- タスクのタイトル・本文を横断検索

---

## 技術スタック

- PHP 8.2+
- CakePHP 5.3
- PostgreSQL 16
- cakephp/authentication（セッション認証）
- cakephp/authorization（Policy 認可）
- PHPUnit 10
- Docker Compose（nginx + php-fpm + postgres）

---

## セットアップ

### 前提
- Docker / Docker Compose
- ポート 8080, 5432 が空いていること

### 手順

```bash
# 1. クローン
git clone git@github.com:TS-NEXTOPT/kanban-cake.git kanban-cake
cd kanban-cake

# 2. 設定ファイル
cp config/app_local.example.php config/app_local.php

# 3. 起動
docker-compose up -d

# 4. 依存インストール
docker-compose exec app composer install

# 5. DB初期化
docker-compose exec app bin/cake migrations migrate

# 6. シードデータ投入
docker-compose exec app bin/cake migrations seed
```

ブラウザで http://localhost:8080 を開く。

### シードユーザー

| email | password | 備考 |
|-------|----------|------|
| alice@example.com | password | プロジェクト1・2 の owner |
| bob@example.com | password | プロジェクト1 の member、プロジェクト3 の owner |
| carol@example.com | password | プロジェクト2・3 の member |
| dave@example.com | password | プロジェクト1 の member |
| eve@example.com | password | プロジェクト未参加 |

---

## 開発コマンド

| 用途 | コマンド |
|------|---------|
| 起動 | `docker-compose up -d` |
| 停止 | `docker-compose down` |
| アプリにシェル | `docker-compose exec app bash` |
| マイグレーション | `docker-compose exec app bin/cake migrations migrate` |
| マイグレーションロールバック | `docker-compose exec app bin/cake migrations rollback` |
| シード投入 | `docker-compose exec app bin/cake migrations seed` |
| テスト全実行 | `docker-compose exec app vendor/bin/phpunit` |
| テスト特定 | `docker-compose exec app vendor/bin/phpunit tests/TestCase/<path>` |
| lint | `docker-compose exec app vendor/bin/phpcs` |
| lint自動修正 | `docker-compose exec app vendor/bin/phpcbf` |
| Bake（コード生成） | `docker-compose exec app bin/cake bake ...` |

---

## ディレクトリ構造

```
kanban-cake/
├── bin/
│   └── cake.php
├── config/
│   ├── Migrations/        # Phinx マイグレーション
│   ├── Seeds/             # シーダー
│   ├── app.php
│   ├── app_local.example.php
│   ├── bootstrap.php
│   └── routes.php
├── src/
│   ├── Application.php    # ミドルウェア・認証認可設定
│   ├── Controller/        # コントローラ
│   ├── Model/
│   │   ├── Entity/        # ORM エンティティ
│   │   └── Table/         # ORM テーブル
│   ├── Policy/            # 認可ポリシー
│   └── Service/           # ビジネスロジック層
├── templates/             # ビューテンプレート
├── tests/
│   └── TestCase/          # テストコード
├── webroot/               # ドキュメントルート
├── docker/
│   ├── nginx/default.conf
│   └── php/Dockerfile
├── docker-compose.yml
├── composer.json
├── phpunit.xml.dist
├── README.md
├── DESIGN.md
└── HANDS_ON.md
```

---

## ドキュメント

| ファイル | 内容 |
|---------|------|
| [DESIGN.md](./DESIGN.md) | 設計書：ER図、テーブル定義、ルーティング、認可ルール |
| [HANDS_ON.md](./HANDS_ON.md) | ハンズオン演習の手順 |

---

## ライセンス

社内研修用途。
