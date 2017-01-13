<?php
session_start();
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', getenv('TWITTER_CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('TWITTER_CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('TWITTER_OAUTH_CALLBACK'));

//アクセストークンをセッションから取得
$access_token = $_SESSION['twitter_access_token'];

//コネクション作成
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//ユーザー情報取得
$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>twitterプロフィール情報</title>
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
</head>
<body>
    <div class="container">
        <h1>twitterプロフィール情報</h1>
        <p>
            セッションに保存されたアクセストークンから、twitterの情報を取得しています。
        </p>
        <?php if (property_exists($user, 'errors')) : ?>
            <?php foreach ($user->errors as $error) : ?>
                <div class="alert alert-danger" role="alert"><?=$error->code?> : <?=$error->message?></div>
            <?php endforeach ?>
        <?php else : ?>
        <p>
            <img src="<?=$user->profile_image_url?>"><br>
            <?=$user->name?><br>
            <?=$user->email?><br>
        </p>
        <?php endif ?>

        <p>
            <ul>
                <li><a href="/twitter/twitter.php">認証しなおし</a></li>
                <li><a href="/index.html">TOPに戻る</a></li>
            </ul>
        </p>

        <h2>raw data</h2>
        <p>
        <pre><?=var_export($user, true)?></pre>
        </p>
    </div>
</body>
</html>
