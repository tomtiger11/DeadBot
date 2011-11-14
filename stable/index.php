<?php

########################################
##### DeadBot IRC Bot - 1.0 STABLE #####
#### www.github.com/Dead-i/DeadBot #####
## See README.md for info and licenseÊ##
########################################

// Include the functions file to give accessibility for core files
require 'functions.php';

// Run the script startup commands
//startup();
require 'config.php';
set_time_limit(0);
$startseconds = time();
$current = date('ymdHis');
$socket = fsockopen('irc.x10hosting.com', 6667);
fputs($socket,"USER ".$nick." ".$name." CM :".$nick."\n");
fputs($socket,"NICK ".$nick."\n");
fputs($socket,"JOIN ".$channel1."\n");
fputs($socket,"JOIN ".$channel2."\n");
sync();
echo "Bot Started";

// Force an endless while
while(1) {

	while($data = fgets($socket, 522)) {
		
		// Flush, update, echo data
		echo nl2br($data);
		flush();
		
		// Play ping-pong to keep the bot active
		if($ex[0] == "PING") { fputs($socket, "PONG ".$ex[1]."\n"); }
		
	}
	
}