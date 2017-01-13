<?php
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;;
session_start();

define('CONSUMER_KEY', getenv('TWITTER_CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('TWITTER_CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('TWITTER_OAUTH_CALLBACK'));

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    // Abort! Something is wrong.
    echo 'Abort! Something is wrong.';
    exit;
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

if ($_REQUEST['oauth_verifier']) {
    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
} else {
    echo 'キャンセルされました。<a href="/index.html">TOPへ戻る</a>';
    exit;
}

$_SESSION['twitter_access_token'] = $access_token;

header('location: /twitter/profile.php');