<?php
switch ($command) {

	case 'help':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the valid commands that can be performed on me. Start all commands with 'deadbot'.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": about, status, random, date, password, welcome, gsearch, gresult, translate\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": For additional help please visit my GitHub page. For admin commands use 'deadbot adminhelp.\n");
		break;
		
	case 'adminhelp':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the valid commands accessible by administrators only.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": addadmin (n), viewadmins (n), deleteadmin (n), shutdown (n), restart (n), sync (n), echo (pm), raw (pm)\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": (n) = Can be run from within channel or private message. (pm) = Must be run through private message.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
	
	case 'status':
		$timeonline = time() - $startseconds;
		$days = $timeonline / 86400;
		$timeonline = $timeonline % 86400;
		$hour = $timeonline / 3600;
		$timeonline = $timeonline % 3600;
		$mins = $timeonline / 60;
		$timeonline = $timeonline % 60;
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I have been connected for: ".round($days)." days, ".round($hour)." hours, ".round($mins)." minutes and ".round($timeonline)." seconds.\n");
		break;
			
	case 'about':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": My name is DeadBot, and I am currently under development by Dead-i.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": You can control me by starting commands with 'deadbot'. For example, 'deadbot about'.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Find out more, report issues, and view my source: https://github.com/Dead-i/DeadBot\n");
		break;
		
	case 'random':
		if ($value == '') $value = 1;
		if ($value2 == '') $value2 = 1000;
		$valueexploderand = explode($value[0], '1234567890');
		$value2exploderand = explode($value2[0], '1234567890');
		if((isset($valueexploderand[1]) && isset($value2exploderand[1])) || ($value == 1 && $value2 == 1000)) {
			if ($value == '') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number: ".rand(0, 1000)."\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number between ".$value." and ".$value2.": ".rand($value, $value2)."\n");
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the random command will only permit integers. You entered ".$value." and ".$value2.". Please use the password command for mixed outputs.\n");
		}
		break;
		
	case 'date':
		$valueexplode = explode('.', $value);
		if (isset($valueexplode[1])) fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I am only able to process whole timezones; I cannot process +/- or fractions. For example, GMT would work, but GMT+4 or GMT+4.5 would not.\n");
		if ($value != NULL) date_default_timezone_set($value);
		if ($value == NULL) date_default_timezone_set('Europe/London');
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": In the timezone specified, it is now ".date('l jS F h:i:s a')." (".date_default_timezone_get().").\n");
		break;
		
	case 'password':
		if ($value == '') $value = '7';
		$valueexploderand = explode($value[0], '1234567890');
		$symbolexploderand = explode('sym', $data);
		$integerexploderand = explode('int', $data);
		if(isset($valueexploderand[1])) {
			$value = (int)$value;
			if (isset($symbolexploderand[1])) {
				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!£$%^&*()';
				$length = 60;
			}else{
				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$length = 51;
			}
			
			if (isset($integerexploderand[1])) {
				$string = $string.'123456789';
				$length = $length + 9;
			}
			
			$count = 0;
			while ($count < $value) {
				$random = rand(0, $length);
				$password = $password.$string[$random];
				$count = $count + 1;
			}
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The requested password has been private messaged to you.\n");
			fputs($socket, "PRIVMSG ".substr($recipient, 1)." :Randomly chosen pasword in which is ".$value." characters long: ".$password."\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the password command will only permit integers as lengths. You requested a password that is '".$value."' long.\n");
		}
		$password = '';
		break;
		
	case 'welcome':
		date_default_timezone_set('Europe/London');
		$languageid = rand(1, 12);
		
		switch ($languageid) {
			
			case '1':
				$lang = 'English';
				$welcome = 'Hello';
				break;
				
			case '2':
				$lang = 'French';
				$welcome = 'Bonjour';
				break;
				
			case '3':
				$lang = 'Spanish';
				$welcome = '¡Hola';
				break;
				
			case '4':
				$lang = 'German';
				$welcome = 'Guten tag';
				break;
				
			case '5':
				$lang = 'Italian';
				$welcome = 'Ciao';
				break;
				
			case '6':
				$lang = 'Irish';
				$welcome = 'Dia duit';
				break;
				
			case '7':
				$lang = 'Welsh';
				$welcome = 'Helo';
				break;
				
			case '8':
				$lang = 'Dutch';
				$welcome = 'Hallo';
				break;
				
			case '9':
				$lang = 'Portuguese';
				$welcome = 'Ola';
				break;
				
			case '10':
				$lang = 'Swedish';
				$welcome = 'Halla';
				break;
				
			case '11':
				$lang = 'Polish';
				$welcome = 'Czesc';
				break;
				
			case '12':
				$lang = 'Icelandic';
				$welcome = 'Hallo';
				break;
				
		}
		
		if ($admin == 1) $welcomeadmin = ' You are an administrator of DeadBot.';
		
		$hostmask = explode('!', $data);
		$hostmask = explode(' ', $hostmask[1]);
		$hostmask = $hostmask[0];
		fputs($socket, "PRIVMSG ".$ex[2]." :".$welcome.", ".$recipient."! Right now it is ".date('l jS F h:i:s a')." in ".date_default_timezone_get().". Your full name and host mask is ".$hostmask.".".$welcomeadmin."\n");
		fputs($socket, "PRIVMSG ".$ex[2]." :And guess what? You just learned how to say hello in ".$lang."! For help here, type 'Bubba help'. To control me, please use 'DeadBot help'.\n");
		break;
		
	case 'gsearch':
		$term = explode('gsearch ', $data);
		$term = $term[1];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://www.google.co.uk/search?q=".substr(urlencode($term), 0, -6)."\n");
		break;
		
	case 'gresult':
		$term = explode('gresult ', $data);
		$term = $term[1];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://www.google.co.uk/search?q=".substr(urlencode($term), 0, -6)."&btnI=1\n");
		break;
	
	case 'translate':
		$value2 = explode($value.' ', $data);
		$value2 = explode(' ', $value2[1]);
		$value2 = $value2[0];
		$value3 = explode($value2.' ', $data);
		$value3 = explode(' @', $value3[1]);
		$value3 = $value3[0];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://translate.google.co.uk/#".$value."|".$value2."|".urlencode($value3)."\n");
		break;
		
	case 'addadmin':
		if ($admin == 1) {
			$fp = fopen('admins.txt', "w");
			fwrite($fp, $adminfile.$value.',');
			fclose($fp);
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been successfully added to the admin log.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": You have been given administrative privledges. Do not abuse it or your privledges will be removed.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'viewadmins':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the current administrators of DeadBot:\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".str_replace(',', ', ', $adminfile)."\n");
		break;
		
	case 'deleteadmin':
		if ($admin == 1) {
			$fp = fopen('admins.txt', "w");
			fwrite($fp, str_replace($value.',', '', $adminfile));
			fclose($fp);
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been deleted from the admin log.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": If you did something bad, shame on you! :P\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'shutdown':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." :Goodbye!\n");
			fputs($socket, "QUIT :Requested by administrator\n");
			die;
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'restart':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." :I will now attempt to restart myself.\n");
			fputs($socket, "QUIT :Restarting as requested by administrator\n");
			shell_exec('screen php /home/kloxo/httpd/default/irc/index.php');
			sleep(2);
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'debug':
		if ($admin == 1) {
			if ($argv[1] == 'debug') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to OFF\n");
				fputs($socket, "QUIT :Requested by administrator\n");
				shell_exec('screen php /home/kloxo/httpd/default/irc/index.php');
				sleep(2);
				die;
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to ON\n");
				fputs($socket, "QUIT :Requested by administrator\n");
				shell_exec('screen php /home/kloxo/httpd/default/irc/index.php debug');
				sleep(2);
				die;
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'sync':
		if ($admin == 1) {
			echo shell_exec('cd /home/kloxo/httpd/default/irc/; /usr/local/bin/git pull');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Synchronized with GitHub. A restart is recommended if the core file was modified.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	default:
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The command you specified was not found. Please type 'deadbot help' if you would like to a see a list of valid commands.\n");
		break;
		
}