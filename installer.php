<?php
	//DONT TOUCH THIS - THE INSTALLER WONT WORK IF YOU DO!

	$fp = fopen("config.php","r+");
	$normal	= "\033[0m";
	$black	= "\033[30m";
	$red	= "\033[31m";
	$green	= "\033[32m";
	$brown	= "\033[33m";
	$blue	= "\033[34m";
	$purple 	= "\033[35m";
	$cyan	= "\033[36m";
	$white	= "\033[37m";
	if (PHP_SAPI !== 'cli') {
		writeout("{$red}You can only install this way via CLI.{$normal}");
		resetcolour();
		exit;
	}
	function resetcolour(){
		system("tput sgr0");
	}
	function fetchinput(){
		return(trim(fgets(STDIN)));
	}
	function writeout($msg="",$newline=true){
		if($newline){
			echo($msg."\r\n");
		}else{
			echo($msg);
		}
	}
	function question($msg){
		writeout($msg.": ",false);
	}
	writeout("{$red}############################");
	writeout("#####DeadBot Installer######");
	writeout("####Made by Tomtiger11#####");
	writeout("###########################{$normal}");
	question("Do you wish to proceed with the configuration? {$red}Note: If you dont fill in all fields, your bot may not function correctly {$cyan}[y/n]{$normal}");
	$input = fetchinput();
	if($input == "y"){
	goto Licence;
	}else{
		writeout("{$red}Closing...{$normal}");
		resetcolour();
		exit;
	}
	Licence:
	writeout("Have you read the license info?");
	question("And do you agree with it? [{$cyan}y/n{$normal}]");
	$input = fetchinput();
	if($input == "y"){
	goto Server;
	}else{
		writeout("{$red}Please read the licence info before installing DeadBot{$normal}");
		resetcolour();
		exit;
	}

	Server:	
	question("Please Input the IRC server you will be using. EG: irc.freenode.net");
	$input = fetchinput();
	$server = $input;
	if($input = ""){
	writeout("{$red}You need to input a server!{$normal}");
	goto Server;
	}else{
	goto Port;
	}

	Port:
	writeout("and what port? DEFAULT: 6667");
	$input = fetchinput();
	if ($input == ""){
	$input = "6667";
	$port = $input;
	}else{
	$input = fetchinput();
	$port = $input;
	goto Staffpass;
	}

	Staffpass:
	writeout("What would you like the Staff Password to be? {$red}(needed for the trust command){$normal}");
	$input = fetchinput();
	$staffpass = $input;
	if($input = ""){
	writeout("{$red}You need to input a Staff Password!{$normal}");
	goto Staffpass;
	}else{
	goto nick;
	}

	nick:
	writeout("What would you like your bots Nick to be?");
	$input = fetchinput();
	$nick = $input;
	if($input = ""){
	writeout("{$red}You need to input a Nick for your bot!{$normal}");
	goto nick;
	}else{
	goto name;
	}

	name:
	writeout("What do you want your bots real name to be?");
	$input = fetchinput();
	$name = $input;
	if($input = ""){
	writeout("{$red}You need to input a real name for your bot!{$normal}");
	goto name;
	}else{
	goto Prefix;
	}

	Prefix:
	writeout("What would you like your bots prefix to be? (e.g @, &, %, $, db, DeadBot)");
	$input = fetchinput();
	$prefix = $input;
	if($input = ""){
	writeout("You need to input a prefix!");
	goto Prefix;
	}else{
	goto channel;
	}
	
	channel:
	writeout("What channel do you want your bot to join automaticly?");
	$input = fetchinput();
	$channels = $input;

	Owner:
	writeout("What is your IRC Nick {$red}(Needed for permissions){$normal}");
	$input = fetchinput();
	$owner = $input;
	if($input = ""){
	writeout("{$red}You need to input an owner nick!{$normal}");
	goto Owner;
	}else{
	goto Pass;
	}

	Pass:
	writeout("What is your bots NickServ Password going to be?");
	$input = fetchinput();
	$pass = $input;
	if($input = ""){
	writeout("{$red}You need to input a NickServ password!{$normal}");
	goto Pass;
	}else{
	goto Write;
	}

	Write:
	$write = "<?php\r\n\$server = '$server';\r\n\$port = $port;\r\n\$nick = '$nick';\r\n\$name = '$name';\r\n\$staffpass = '$staffpass';\r\n\$channels = '$channels';\r\n\$prefix = '$prefix';\r\n\$pass = '$pass'\r\n\?>\r\n";
	fwrite($fp,$write);
	fclose($fp);
	$fp = fopen("admins.txt","r+");
	fwrite($fp,$owner);
	fclose($fp);
	writeout("{$green}Configuration Successful! {$normal}Have fun with your bot!");
	exit;


?>