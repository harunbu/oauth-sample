<?php
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
session_start();

define('CONSUMER_KEY', getenv('TWITTER_CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('TWITTER_CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('TWITTER_OAUTH_CALLBACK'));

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

header('location: ' . $url);