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
fputs($socket,"NS IDENTIFY ".$password."\n"); 

// Join channels
fputs($socket,"JOIN #publicchat\n");
fputs($socket,"JOIN #paidhosting\n");

// Get the admin files
$adminfile = file_get_contents('./admins.txt');
$hostmasks = file_get_contents('./hostmasks.txt');

$current = date('ymdHis');

// Force an endless while
while(1) {
 
	// Check if someone needs voicing
	$currentdate = date('His');
	while (($currentdate - $voicetime) >= 10 && $voicetime != '') {
		echo "\nDEBUG\n";
		fputs($socket, "MODE ".$voicechnl." +v ".$voiceuser."\n");
		sleep(1);
		$voicetime = '';
	}
	
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
		
		// Get the user's name; useful in many purposes
		$userinfo = explode("!", $ex[0]);
		
		// Get the value if any
		$value = str_replace(array(chr(10), chr(13)), '', $ex[5]);
		if ($value == '@') $value = '';
		
		// Get the second value if any
		$value2 = str_replace(array(chr(10), chr(13)), '', $ex[6]);
		$value2exploderand = explode($value2[0], '1234567890');
		if (!isset($value2exploderand[1])) $value2 = '';
		
		// Explode the command; useful in many purposes
		$explode = explode(' ', $command);
		
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
		
		// Hostmask detection
		$hostmask = explode('!', $data);
		$hostmask = explode('@', $hostmask[1]);
		$hostmask = explode(' ', $hostmask[1]);
		$hostmask = $hostmask[0];
		
		// Admin detection
		$adminarray = explode(substr($userinfo[0], 1), $adminfile);
		$hostsarray = explode($hostmask, $hostmasks);
		if (isset($adminarray[1]) && isset($hostsarray[1])) {
			$admin = 1;
		}else{
			$admin = 0;
		}
		
		// General flood protection for #paidhosting
		$fp = file_get_contents('last.csv');
		$fpresult = explode(',', 'last.csv');
		foreach ($fpresult as $fpvalue) {
			$count++;
			$variable = 'csv'.$count;
			$$variable = $fpvalue;
		}
		
		$fp = fopen('last.csv', "w");
		
		if ($ex[2] == '#paidhosting' && $ex[1] == 'PRIVMSG') {
			$csv1 = $csv3;
			$csv2 = $csv4;
			$csv3 = $csv5;
			$csv4 = $csv6;
			$csv5 = date('His');
			$csv6 = substr($userinfo[0], 1);
			fwrite($fp, $csv1.','.$csv2.','.$csv3.','.$csv4.','.$csv5.','.$csv6);
		}
		
		if ($csv2 != 'last.csv' && $ex[2] == '#paidhosting' && isset($command) && ($csv1 - $csv3 - $csv5) <= 2 && $csv1 == $csv3 && $csv2 == $csv6 && $admin != 1 && !isset($listentime)) {
			fputs($socket, "MODE ".$ex[2]." -v ".$csv2."\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$csv2.": You have been devoiced 15 seconds for flooding.\n");
			$voicetime = date('His');
			$voiceuser = $csv2;
			$voicechnl = $ex[2];
			fwrite($fp, '');
			sleep(1);
		}
		
		fclose($fp);
		
		/*if (isset($this->$user) && $userinfo[0] == ':NickServ') {
			$adminstatus = explode('STATUS '.$this->$user.' ', $data);
			$adminstatus = $adminstatus[1];
			$adminstatus = $adminstatus[0];
			if ($adminstatus == '3') {
				$admin = 1;
				$this->$user = NULL;
			}else{
				$admin = 0;
			}
		}*/
		
		// Get the entire command
		$entirecommandraw = explode(' :', $data);
		$entirecommandraw = $entirecommandraw[1];
		$entirecommandraw = substr($entirecommandraw, 0, -2);
		
		// Get the start message for each command
		$startmsg = "PRIVMSG ".$ex[2]." ".$recipient.":";
		
		// If the bot was directed at
		$direct = str_replace(array(chr(10), chr(13)), '', $ex[3]);
		$direct = strtolower($direct);
		if ($direct == ':deadbot' || $direct == ':db') {
			
			// Attempt to detect excess flooding and hacking
			$current = date('ymdHis');
			if (!(($current - $lastmsg) < 1 && $abuser == $userinfo[0]) && $recipient[1] != '!') {
				
				// Get the commands
				include 'cmd.php';
				
			// End of flooding detection
			}
			$lastmsg = date('ymdHis');
			$abuser = $userinfo[0];
			
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
		
		// If DeadBot gets a permission denied error
		if ($ex[2] == 'DeadBot' && ($ex[3] == ':Permission' || $ex[3] == ':Access')) {
			fputs($socket,"PRIVMSG ".$channel." :I was instructed to run a command that I could not perform; I had insufficient priviledges on the specific channel.\n");
		}
		
	}
 
}
?>