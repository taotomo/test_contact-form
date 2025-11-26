# ER図 (Mermaid)

以下はこのプロジェクト用に作成したテーブル仕様（`contacts` / `categories` / `users`）に基づくER図です。

- 仕様ソース: `src/database/migrations/2023_10_15_081426_create_contacts_table.php` と `docs/テーブル仕様書`
- 備考: `gender` は整数で保存 (1=男性,2=女性,3=その他)。`contacts.category_id` は `categories.id` の外部キー。

Mermaid をプレビューするには VSCode の Mermaid 拡張（例: `vstirbu.vscode-mermaid-preview`）を使ってこのファイルを開いてください。

```mermaid
erDiagram
    %% テーブル定義（フィールド名 : 型 [PK/FK/注記]）
    CONTACTS {
        id bigint PK
        category_id bigint FK "references categories.id"
        first_name varchar
        last_name varchar
        gender tinyint "1=男性,2=女性,3=その他"
        email varchar
        tel varchar
        address varchar
        building varchar
        detail text
        created_at timestamp
        updated_at timestamp
    }

    CATEGORIES {
        id bigint PK
        content varchar
        created_at timestamp
        updated_at timestamp
    }

    USERS {
        id bigint PK
        name varchar
        email varchar
        password varchar
        created_at timestamp
        updated_at timestamp
    }

    %% リレーション（CATEGORIES 1 --- * CONTACTS）
    CATEGORIES ||--o{ CONTACTS : "has"

    %% 備考: 現在のスキーマでは CONTACTS に user_id は存在しません。
```

説明:
- `CONTACTS.category_id` は `CATEGORIES.id` を参照する外部キーです。
- `USERS` テーブルは管理ユーザー用です（シーダーで `admin@example.com` を作成しています）。

必要であれば以下を追加できます:
- `contacts.user_id` を追加して問い合わせ作成者(担当)を紐付ける
- 各カラムに `NOT NULL` やインデックス情報を追記

どの情報を図に追加するか教えてください（例: `user_id` を追加して users と結びたい、NOT NULL を明示したい、など）。
