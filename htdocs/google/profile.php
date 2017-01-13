<?php
session_start();
require "../../vendor/autoload.php";

//Google Client の初期化
$client = new Google_Client();
$client->setAuthConfig(getenv('GOOGLE_CLIENT_CREDENTIALS_PATH'));

//アクセストークンをセッションから取得
$token = $_SESSION['google_oauth_token'];
$client->setAccessToken($token);

//アクセストークン中に含まれるユーザーデータを確認
$ticket = $client->verifyIdToken($token['id_token']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>googleメールアドレス情報</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<body>
    <div class="container">
        <h1>googleユーザー情報</h1>

        <h2>取得したメールアドレス</h2>
        <p><?=$ticket['email']?></p>

        <h2>raw data</h2>
        <pre><?=var_export($ticket, true)?></pre>

        <p>
        <ul>
            <li><a href="/index.html">TOPに戻る</a></li>
        </ul>
        </p>
    </div>
</body>
</html>