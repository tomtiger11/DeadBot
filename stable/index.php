<?php

########################################
##### DeadBot IRC Bot - 1.0 STABLE #####
#### www.github.com/Dead-i/DeadBot #####
## See README.md for info and license�##
########################################

// Include the configuration file to give core information
require 'config.php';

// Include the core functions required for the bot to function
require 'functions.php';

set_time_limit(0);
$startseconds = time();
$current = date('ymdHis');
$socket = fsockopen($network, 6667);
raw("USER ".$nick." ".$name." CM :".$nick);
raw("NICK ".$nick);
raw("JOIN ".$channel1);
raw("JOIN ".$channel2);

startup();

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