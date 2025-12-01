# test_contact-form

## 環境構築
### Dockerビルド
- git clone https://github.com/taotomo/test_contact-form.git
- docker-compose up -d --build

### Laravel環境構築
- docker-compose exec php bash
- composer install
- cp .env.example .env , 環境変数を適宜変更
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

## 開発環境
  - お問い合わせ画面：http://localhost/  
  - ユーザー登録: http://localhost/register  
  - phpMyAdmin：http://localhost:8080/

## 使用技術(実行環境)
- PHP 8.2.29
- Laravel 8.83.27
- jquery 3.7.1.min.js
- MySQL 8.0.26
- nginx 1.21.1

## ER図
```mermaid
erDiagram

  categories ||--o{ contacts: "relation"

  contacts {
    bigint id PK
    bigint categry_id FK
    varchar(255) first_name "NOT NULL"
    varchar(255) last_name "NOT NULL"
    tinyint gender "NOT NULL"
    varchar(255) email "NOT NULL"
    varchar(255) tell "NOT NULL"
    varchar(255) address "NOT NULL"
    varchar(255) building
    text detail "NOT NULL"
    timestamp created_at
    timestamp deleted_at
  }

   categories{
    bigint id PK
    varchar(255) content "NOT NULL"
    timestamp created_at
    timestamp deleted_at
  }

  users {
    bigint id PK
    varchar(255) name "NOT NULL"
    varchar(255) email "NOT NULL"
    varchar(255) password "NOT NULL"
    timestamp created_at
    timestamp deleted_at
  }
```
