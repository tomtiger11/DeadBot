<?php
 
###########################################
######## DeadBot IRC Bot PHP-Beta #########
##### Created by tomtiger11 & Dead-i ######
###########################################

// Set no time limit; run forever
set_time_limit(0);


// Get the start date incase of status command

$startseconds = time();

// Opening the socket to the freenode network
$socket = fsockopen($server, $port);
 
//Getting Functions
require "functions.php";
// Send auth info
fputs($socket,"USER {$nick} {$name} CM :{$nick}\n");
fputs($socket,"NICK {$nick}\n");
fputs($socket,"NS IDENTIFY {$pass}\n"); 

// Join channelfputs($socket,"JOIN {$channels}\n");
fputs($socket,"JOIN {$channels}\n");
// Get the admin files
$adminfile = file_get_contents('./admins.txt');
$admin2 = file_get_contents('./admin2.txt');
$admin3 = file_get_contents('./admin3.txt');
$hostmasks = file_get_contents('./hostmasks.txt');

// Force an endless while
while(1) {
 


	// Continue the rest of the script here
	while($data = fgets($socket, 522)) {
		
		if ($argv[1] == 'debug') {
			echo nl2br($data);
$fp = fopen('log.txt', "w");
fwrite($fp, nl2br($data).'\n');
fclose($fp);

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


$userinfo = explode("!", $ex[0]);

		
		// Detect if message is private
		if ($ex[2] == 'botnick') {
			$ex[2] = substr(strtolower($recipient), 1);
		}
		
		// Hostmask detection
		$hostmask = explode('!', $data);
		$hostmask = explode('@', $hostmask[1]);
		$hostmask = explode(' ', $hostmask[1]);
		$hostmask = $hostmask[0];
		
		// Admin detection
		$adminarray = explode(substr($userinfo[0], 1), $adminfile);
		$admin21 = explode(substr($userinfo[0], 1), $admin2);
		$admin31 = explode(substr($userinfo[0], 1), $admin3);

		$hostsarray = explode($hostmask, $hostmasks);
		if (isset($adminarray[1]) && isset($hostsarray[1])) {
			$admin = 1;
		

}else{
			$admin = 0;
		}		
if (isset($admin21[1]) && isset($hostsarray[1])) {
			$admin = 2;
		}else{
			$admin = 0;
		

}		if (isset($admin31[1]) && isset($hostsarray[1])) {
			$admin = 3;
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
		if ($direct == $prefix) {
	$valuelow = strtolower ($value);				
			// Attempt to detect excess flooding

$current = date('ymdHis');
if (!(($current - $lastmsg) < 1 && $abuser == $userinfo[0])) {
// Get the commands
if ($recipient[1] != '!' || $recipient[1] != '/') { include 'cmd.php'; }
}
// End of flooding detection
}			
$lastmsg = date('ymdHis');			
$abuser = $userinfo[0];
										// Attempt to detect excess flooding 
			
		

 		
		// Get the sayings
		include 'sayings.php';
		
		// Admin echo command
		if ($admin != 0 || $admin != 1 || $admin != 2) {
			$content = explode('echo ', $data);
			$content = $content[1];
			if ($ex[3] == ':echo') {
				if ($ex[2] != $channels) {
					fputs($socket, "PRIVMSG {$channels} :".$content."\n");
				}
			}
		}
		
		// Admin raw command
		if ($admin != 0 || $admin != 1 || $admin != 2) {
			$content = explode('raw ', $data);
			$content = $content[1];
			if ($ex[3] == ':raw') {
				if ($ex[2] != $channels) {
					fputs($socket, $content."\n");
				}
			}
		}
		
		// If BotNick is kicked
		$kick = explode('KICK', $data);
		if (isset($kick[1])) {
			$kickedby = explode('!', $data);
			fputs($socket,"JOIN {$channels}\n");
		}
		
	}
 
}
?>
