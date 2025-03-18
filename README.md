# Café Lumière
カフェのECサイト

# 作成した目的
オンラインを使用して多くのユーザーに利用してもらいたいため

#　アプリケーションURL
<開発環境>

phpmyadmin: http://localhost:8080
アプリURL: [http://localhost/register]

#　他のリポジトリ
<開発環境>

https://github.com/mana62/cafe_app

# 機能一覧
[ユーザー管理]
- ユーザー登録
- ログイン
- ログアウト
- メール認証
- ユーザー情報編集
[商品・注文機能]
- 商品一覧
- 商品詳細
- カート機能
- 注文履歴管理
[決済機能]
- Stripe決済（テスト環境）
[レビュー機能]
- 商品レビュー投稿・管理
[UI・データ処理]
- ページネーション
- バリデーション
- レスポンシブデザイン
[管理者機能]
- ユーザー管理（一覧・削除）
- 商品管理（追加・更新・削除）
- 注文管理（一覧・詳細）
[お問い合わせ機能]
- 問い合わせフォーム（入力・確認・送信）

# 使用技術
- nginx: latest
- php: 8.1-fpm
- mysql: 8.0.26
- Laravel: 8

# テーブル設計

[Book.pdf](https://github.com/user-attachments/files/19304397/Book.pdf)

# ER図

<img width="799" alt="Image" src="https://github.com/user-attachments/assets/8fd36294-ffbe-43a2-af26-aed5894a6df6" />

# 環境構築
1. リモートリポジトリを作成
2. ローカルリポジトリの作成
3. リモートリポジトリをローカルリポジトリに追加
4. docker-compose.yml の作成
5. Nginx の設定
6. PHP の設定
7. MySQL の設定
8. phpMyAdmin の設定
9. docker-compose up -d --build
10. docker-compose exec php bash
11. composer create-project "laravel/12. laravel=8.*" . --prefer-dist
12. app.php の timezone を修正
13. .env ファイルの環境変数を変更
14. php artisan migrate
15. php artisan db:seed

# クローンの流れ
1. Git リポジトリのクローン<br>
「 git@github.com:mana62/cafe_app.git 」<br>
「 cd cafe_app 」
2. .env ファイルの作成<br>
「 cp .env.example .env 」<br>
3. .env ファイルの編集<br>
<br>
DB_CONNECTION=mysql<br>
DB_HOST=mysql<br>
DB_PORT=3306<br>
DB_DATABASE=cafe_db<br>
DB_USERNAME=user<br>
DB_PASSWORD=pass<br>
<br>
MAIL_MAILER=smtp<br>
MAIL_HOST=mailhog<br>
MAIL_PORT=1025<br>
MAIL_USERNAME=null<br>
MAIL_PASSWORD=null<br>
MAIL_ENCRYPTION=null<br>
MAIL_FROM_ADDRESS=test@example.com<br>
MAIL_FROM_NAME="Café Lumière"<br>
<br>
https://stripe.com/jp から下記2つのキーを取得して記載する<br>
STRIPE_KEY=<br>
STRIPE_SECRET=<br>
<br>

4. Dockerの設定<br>
「 docker compose up -d --build 」
5. PHPコンテナにアクセス<br>
「 docker compose exec php bash 」
6. Laravelパッケージのインストール<br>
「 composer install 」
7. アプリケーションキーの生成<br>
「 php artisan key:generate 」
8. マイグレーション<br>
「 php artisan migrate 」
9. シーディング<br>
「 php artisan db:seed 」
10. シンボリックリンク<br>
「 php artisan storage:link 」

# 補足
[管理者のログイン]
- メールアドレス： admin@example.com
- パスワード： admin123

