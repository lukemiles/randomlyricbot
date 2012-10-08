<?php
//require function that picks song
require 'random.php';

$tweet_text = stripslashes(randomLyric());
print "Posting...\n";
$result = post_tweet($tweet_text);
print "Response code: " . $result . "\n";

function post_tweet($tweet_text) {
require 'tmhOAuth.php';
//To hide my keys from github, i placed them as variables in a separate PHP file.
//Feel free to remove the next line and to replace the variable in the connection with your own.
require 'auth.php';
      
$connection = new tmhOAuth(array(
  'consumer_key'    => $consumer_key,
  'consumer_secret' => $consumer_secret,
  'user_token'      => $user_token,
  'user_secret'     => $user_secret,
));
  // Make the API call
  $connection->request('POST', 
    $connection->url('1/statuses/update'), 
    array('status' => $tweet_text));
  
  return $connection->response['code'];
}