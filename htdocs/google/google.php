<?php
session_start();
require "../../vendor/autoload.php";

//偽造対策のトークンを作成
$state = sha1(openssl_random_pseudo_bytes(1024));
$_SESSION['google_oauth_state'] = $state;

//Google Client の初期化
//事前にGoogleAPIの認証情報jsonをサーバー上に配置し、
//パスを環境変数「GOOGLE_CLIENT_CREDENTIALS_PATH」として定義しています。
$client = new Google_Client();
$client->setAuthConfig(getenv('GOOGLE_CLIENT_CREDENTIALS_PATH'));
$client->addScope(Google_Service_Plus::USERINFO_EMAIL);// EmailAddressを取得するスコープを追加
$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));
$client->setState($state);

//認証用URLの生成
$auth_url = $client->createAuthUrl();

header('location: ' . $auth_url);