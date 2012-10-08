<?
function randomLyric () {
	//create an array of all of the files in the directory
	$songs = glob("/home/ubuntu/twitterbot/songs/*.txt");

	//picks a random file, uses it as the song
	$song = $songs[array_rand($songs, 1)];

	//loads the content of the lyric file
	$f_contents = file($song);

	//picks a random line
	$line = $f_contents[array_rand($f_contents)];

	return $line;
}
?>