<?php

########################################
##### DeadBot IRC Bot - 1.0 STABLE #####
#### www.github.com/Dead-i/DeadBot #####
## See README.md for info and licenseÊ##
########################################

// Include the configuration file with important information about the bot
require 'config.php';

// Include the functions file to give accessibility for core files
require 'functions.php';

// Run the script startup commands
startup();

// Force an endless while
while(1) {

	while($data = fgets($socket, 522)) {
		
		// Flush, update, echo data
		echo nl2br($data);
		flush();
		
		// Play ping-pong to keep the bot active
		if($ex[0] == "PING"){ fputs($socket, "PONG ".$ex[1]."\n"); }
		
	}
	
}