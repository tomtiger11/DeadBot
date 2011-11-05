<?php
 
##############################
## DeadBot IRC Bot PHP-Beta ##
##### Created by Dead-i ######
##############################

// Require the configuration file
// This should contain the $password
require 'config.php';

// Set no time limit; run forever
set_time_limit(0);

// Get the start date incase of status command
$startseconds = time();

// Opening the socket to the freenode network
$socket = fsockopen("irc.x10hosting.com", 6667);
 
// Send auth info
fputs($socket,"USER DeadBot deadi CM :DeadBot\n");
fputs($socket,"NICK DeadBot\n");
fputs($socket,"NS IDENTIFY somepassword\n"); 

// Join channel
fputs($socket,"JOIN #publicchat\n");

// Force an endless while
while(1) {
 
	// Continue the rest of the script here
	while($data = fgets($socket, 522)) {
		
		if ($argv[1] == 'debug') {
			echo nl2br($data);
		}
		flush();
 
		// Separate all data
		$ex = explode(' ', $data);
 
		// Send PONG back to the server
		if($ex[0] == "PING"){
			fputs($socket, "PONG ".$ex[1]."\n");
		}
		
		// Say something in the channel
		$command = str_replace(array(chr(10), chr(13)), '', $ex[4]);
		
		// Get the value if any
		$value = str_replace(array(chr(10), chr(13)), '', $ex[5]);
		if ($value == '@') $value = '';
		
		// Get the second value if any
		$value2 = str_replace(array(chr(10), chr(13)), '', $ex[6]);
		$value2exploderand = explode($value2[0], '1234567890');
		if (!isset($value2exploderand[1])) $value2 = '';
		
		// Explode the command; useful in many purposes
		$explode = explode(' ', $command);
		
		// Get the user's name; useful in many purposes
		$userinfo = explode("!", $ex[0]);
		
		// Detect if the message was directed toward someone
		$directionexplode = explode(' @ ', $data);
		if (!isset($directionexplode[1])) {
			$recipient = $userinfo[0];
		}else{
			$recipient = ":".substr($directionexplode[1], 0, -2);
		}
		
		// Detect if message is private
		if ($ex[2] == 'deadbot') {
			$ex[2] = substr(strtolower($recipient), 1);
		}
		
		// Admin detection
		$adminfile = file_get_contents('./admins.txt');
		$adminarray = explode(substr($userinfo[0], 1), $adminfile);
		if (isset($adminarray[1])) {
			$admin = 1;
		}else{
			$admin = 0;
		}
		
		// Get the entire command
		$entirecommandraw = explode(' :', $data);
		$entirecommandraw = $entirecommandraw[1];
		$entirecommandraw = substr($entirecommandraw, 0, -2);
		
		// Get the start message for each command
		$startmsg = "PRIVMSG ".$ex[2]." ".$recipient.":";

		// If the bot was directed at
		$direct = str_replace(array(chr(10), chr(13)), '', $ex[3]);
		$direct = strtolower($direct);
		if ($direct == ':deadbot') {
			
			// Get the commands
			include 'cmd.php';
			
		}
		
		// Get the sayings
		include 'sayings.php';
		
		// Admin echo command
		if ($admin == 1) {
			$content = explode('echo ', $data);
			$content = $content[1];
			if ($ex[3] == ':echo') {
				if ($ex[2] != '#publicchat') {
					fputs($socket, "PRIVMSG #publicchat :".$content."\n");
				}
			}
		}
		
		// Admin raw command
		if ($admin == 1) {
			$content = explode('raw ', $data);
			$content = $content[1];
			if ($ex[3] == ':raw') {
				if ($ex[2] != '#publicchat') {
					fputs($socket, $content."\n");
				}
			}
		}
		
		// If DeadBot is kicked
		$kick = explode('KICK', $data);
		if (isset($kick[1])) {
			$kickedby = explode('!', $data);
			fputs($socket,"JOIN #publicchat\n");
		}
		
	}
 
}
?>