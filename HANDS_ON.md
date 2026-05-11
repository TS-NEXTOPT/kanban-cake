# HANDS_ON.md — 受講者用ハンズオン

KanbanCake は社内向け簡易プロジェクト・タスク管理ツール。本ハンズオンでは、ClaudeCode を使ってこのアプリのコードを読み・直し・改善する。

---

## 0. セットアップ

### 0.1 前提
- Docker / Docker Compose が動作する環境
- ClaudeCode が利用可能（Pro / Max プラン）
- Claude.ai のオプトアウト設定済み（Settings > Privacy > "Help improve Claude" を OFF）

### 0.2 手順

```bash
# 1. リポジトリ取得
git clone git@github.com:TS-NEXTOPT/kanban-cake.git kanban-cake
cd kanban-cake

# 2. 設定ファイルコピー
cp config/app_local.example.php config/app_local.php

# 3. 起動
docker-compose up -d

# 4. 依存インストール
docker-compose exec app composer install

# 5. DB初期化
docker-compose exec app bin/cake migrations migrate

# 6. シードデータ投入
docker-compose exec app bin/cake migrations seed

# 7. 確認
# ブラウザで http://localhost:8080 を開く
```

### 0.3 シードユーザー

| email | password | 備考 |
|-------|----------|------|
| alice@example.com | password | プロジェクト1, 2 のowner |
| bob@example.com | password | プロジェクト1 のmember、プロジェクト3 のowner |
| carol@example.com | password | プロジェクト2, 3 のmember |
| dave@example.com | password | プロジェクト1 のmember のみ |
| eve@example.com | password | どのプロジェクトにも未参加 |

---

## 演習1: コードのQ&A（15分）

ClaudeCode を起動し、このアプリのコードベースを質問で探索する。

### 推奨の質問
- 「このプロジェクトの認証はどう実装されている？」
- 「タスクと関連するテーブルとカラムを一覧化して」
- 「ダッシュボードはどんなデータを取得して表示している？」
- 「タグはどのテーブルとどう関連している？」
- 「権限チェックはどこでどう行われている？」
- 「`/search` の実装はどこにある？検索のクエリはどう組み立てている？」

### 自由質問
- このアプリの全体構成を 5分でつかむ
- 自分の業務で「気になった設計判断」を ClaudeCode に問う

### 進め方のコツ
- いきなり実装に踏み込まず、まずは「読む」フェーズと割り切る
- ClaudeCode の応答に出てきたファイル名は実際に開いて確認する
- 不明点はそのまま掘り下げる

---

## 演習2: バグの調査と修正（30分）

いくつかバグが報告されている。
原因を調査し、修正せよ。

### Bug A
> 「他人のプロジェクトのタスク詳細URLを直接打つと、編集画面が出てしまい、保存もできてしまう。」

### Bug B
> 「ダッシュボードがタスク数が増えると重い。」

### Bug C
> 「期限が今日のタスクが『期限切れ』と表示されてしまう。仕様では『今日中＝期限内』のはず」

### Bug D
> 「タスクにタグを付ける際、既存タグと同じ名前を入力すると tags テーブルに重複行ができる」

### ClaudeCode 活用のヒント
- まず Plan モード（`Shift+Tab` x2）で原因調査と修正計画を立てさせる
- 計画をレビューしてから実装承認
- 修正後はテストを追加してリグレッションを防ぐ

---

## 演習3: リファクタリング（45分）

`src/Controller/TasksController.php` の `add()` メソッドが**肥大化**している。
バリデーション・保存・通知メール・タグ処理・キャッシュ更新がすべて1メソッドに同居しており、読みづらい・テストしづらい・変更に弱い。

### 課題
このメソッドを安全にリファクタせよ。

### 必須条件
- **既存機能を一切変えない**
- **既存テストが緑のまま**
- リファクタ後、責務分離されたコードに対して**新規テストを追加**する

---

## 演習4（発展）: 新規機能追加

時間が余った受講者向け。以下のいずれか1つを選んで実装せよ。

### 選択肢A: 添付ファイル機能
- タスクに複数ファイルを添付できる
- ファイルは `tmp/uploads/` に保存
- 添付一覧表示・ダウンロード・削除
- ファイルサイズ上限（例: 10MB）
- 拡張子制限（任意）

### 選択肢B: タスク履歴機能
- タスクの変更履歴を記録（誰がいつ何を変更したか）
- `task_histories` テーブル追加
- タスク詳細画面で履歴を時系列表示
- 変更内容は diff 形式（before / after）で保持

### 進め方
- Plan モードで設計提示 → 承認 → 実装
- 既存機能を壊さないよう PostToolUse hook 等でテスト自動実行を推奨

---

## 提出物（任意）

各演習後、以下を発表用にまとめておくと共有が楽：
- どんなプロンプトを ClaudeCode に渡したか
- ClaudeCode の Plan に対してどんな反論・修正をしたか
- 詰まったポイント・気づき
- 修正前後の差分（git diff）

---

## トラブルシューティング

### docker-compose / docker compose の表記揺れ
- 本ドキュメントは Docker Compose v2 の `docker compose` 記法（スペース区切り）と v1 の `docker-compose` 記法（ハイフン区切り）を混在させている可能性がある
- 環境に応じて読み替えること。v2 推奨

### 初回 `docker compose up -d` が遅い / タイムアウトしたように見える
- postgres:16 / php:8.2 等のイメージを初回 pull するため、初回は数分かかる
- `docker compose logs -f` で進捗確認

### `docker compose up -d` でDBが立ち上がらない
- ポート 5432 が他で使われていないか確認
- `docker compose down -v` で volume ごと初期化して再試行

### `cp config/app_local.example.php config/app_local.php` 忘れによる DB 接続エラー
- 症状: `migrations migrate` 等で `Database connection "default" is missing` 等
- 対処: §0.2 手順 2 を再実行 → `docker compose restart app`

### Migrations 実行でエラー
- DB接続設定（`config/app_local.php`）を確認
- DB が起動しきっているか `docker compose logs db` で確認（"database system is ready to accept connections" を待つ）

### `vendor/bin/phpunit` が初回失敗する
- 症状: テスト DB に接続できない / fixture が作れない
- 対処: `phpunit.xml.dist` の `Datasources.test` 設定が `config/app_local.php` の値と整合しているか確認
- それでも fail する場合は `docker compose exec app bin/cake migrations migrate -c test` で test DB を初期化

### ClaudeCode が遠慮して動かない
- Plan モードを抜けたか確認（`Shift+Tab` で auto-accept または normal モード）
- それでもダメなら `/permissions` で対象操作を許可
