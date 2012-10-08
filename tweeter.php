<?php


//This script picks a random text file from a directory and picks a random line. It take the random line and tweets it, and it takes the filename (minus the extension) and updates the location with it
//Sorry for the messy code.

//picks file and gets lyric and name of song
	//create an array of all of the files in the directory
	$songs = glob("/home/ubuntu/twitterbot/songs/*.txt");

	//picks a random file, uses it as the song
	$song = $songs[array_rand($songs, 1)];

	//loads the content of the lyric file
	$f_contents = file($song);

	//removes file path and extension, so we get a clean title to update the location with
	$removefilename = str_replace("/home/ubuntu/twitterbot/songs/", "", "$song");
	$title = substr($removefilename,0,-4);

	//picks a random line
	$line = $f_contents[array_rand($f_contents)];


//shelloutput

$tweet_text = stripslashes($line);
print "Updating Status...\n";
$result = post_tweet($tweet_text);
print "Response code: " . $result . "\n";
print "Updating location...\n"
$result2 = update_location($title);
print "Response code: " . $result2 . "\n";


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

function update_location($title) {
require 'auth.php';
  
$connection = new tmhOAuth(array(
  'consumer_key'    => $consumer_key,
  'consumer_secret' => $consumer_secret,
  'user_token'      => $user_token,
  'user_secret'     => $user_secret,
));
  // Make the API call
  $connection->request('POST', 
    $connection->url('1/account/update_profile'), 
    array('location' => $title));
  
  return $connection->response['code'];
}