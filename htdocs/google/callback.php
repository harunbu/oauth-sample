<?php
session_start();
require "../../vendor/autoload.php";

//偽造対策のトークンを確認
if ($_SESSION['google_oauth_state'] != $_GET['state']) {
    echo 'エラーです。stateが一致しません。';
    echo '<hr>';
    var_dump($_SESSION['google_oauth_state']);
    echo '<hr>';
    var_dump($_GET['state']);
    exit;
}

//Google Client の初期化
$client = new Google_Client();
$client->setAuthConfig(getenv('GOOGLE_CLIENT_CREDENTIALS_PATH'));
$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));

//コードからアクセストークンを取得
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

//アクセストークンを保存
$_SESSION['google_oauth_token'] = $token;

header('location: /google/profile.php');