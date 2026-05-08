-- POSTGRES_DB=kanban で kanban DB は自動作成される。test_kanban のみここで作成。
CREATE DATABASE test_kanban;
GRANT ALL PRIVILEGES ON DATABASE test_kanban TO kanban;
