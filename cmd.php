<?php
switch ($command) {

	case 'help':		if($value == "dice"){  fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": End 'botnick dice' with a space and '10' for a 10 sided dice, or '20' for 2 10 sided dice, or '100' for a 100 sided dice.\n");
		

	fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": For Example, 'botnick dice 100' would roll a 100 sided dice.\n");}else{	if ($admin != 0) { $helpadmin = ' For a list of admin commands type, "botnick adminhelp".';
}	

	
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the valid commands that can be performed on me. Start all commands with 'botnick'.\n");
		fputs($socket, 

"PRIVMSG ".$ex[2]." ".$recipient.": about, status, calc, random, date, password, welcome, gsearch, gresult, translate, roulette, dice\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": For additional help 

please visit my GitHub page.".$helpadmin."\n");
}		break;
		
	case 'adminhelp':
		if ($admin != 0) {
			fputs($socket, "PRIVMSG ".substr($recipient, 1)." Here are the valid 

commands accessible by administrators only.\n");
			fputs($socket, "PRIVMSG ".substr($recipient, 1)." trust (n), warn (n), op (n), ban (n), kick (n), deop (n), addadmin (n), viewadmins (n), deleteadmin (n), 

shutdown (n), restart (n), sync (n), echo (pm), raw (pm)\n");
			fputs($socket, "PRIVMSG ".substr($recipient, 1)." (n) = Can be run from within channel or private message. (pm) = Must be run through private 

message.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n");
		}
		break;
	
	

case 'status':
		$timeonline = time() - $startseconds;
		$days = $timeonline / 86400;
		$timeonline = $timeonline % 86400;
		$hour = $timeonline / 3600;
		$timeonline = 

$timeonline % 3600;
		$mins = $timeonline / 60;
		$timeonline = $timeonline % 60;
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I have been connected for: ".round($days)." days, 

".round($hour)." hours, ".round($mins)." minutes and ".round($timeonline)." seconds.\n");
		break;
			
	case 'about':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": My 

name is BotNick, and I am currently under development by Tomtiger11 & Dead-i. GtoXic has NOT helped with this bot!\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": You can control me by starting commands 

with 'botnick'. For example, 'botnick about'.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Find out more, report issues, and view my source: https://github.com/Dead-i/DeadBot\n");
		break;
		
	case 'random':
		if ($value == '') $value = 1;
		if ($value2 == '') $value2 = 1000;
		$valueexploderand = explode($value[0], '1234567890');
		$value2exploderand = explode

($value2[0], '1234567890');
		if((isset($valueexploderand[1]) && isset($value2exploderand[1])) || ($value == 1 && $value2 == 1000)) {
			if ($value == '') {
				fputs($socket, 

"PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number: ".rand(0, 1000)."\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number 

between ".$value." and ".$value2.": ".rand($value, $value2)."\n");
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the random command will only permit 

integers. You entered ".$value." and ".$value2.". Please use the password command for mixed outputs.\n");
		}
		break;
		
	case 'date':
		$valueexplode = explode('.', 

$value);
		if (isset($valueexplode[1])) fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I am only able to process whole timezones; I cannot process +/- or fractions. For example, GMT would work, but GMT+4 or GMT+4.5 

would not.\n");
		if ($value != NULL) date_default_timezone_set($value);
		if ($value == NULL) date_default_timezone_set('Europe/London');
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": In the 

timezone specified, it is now ".date('l jS F h:i:s a')." (".date_default_timezone_get().").\n");
		break;
		
	case 'password':		if ($value == '') $value = '7';		$valueexploderand = 

explode($value[0], '1234567890');		$symbolexploderand = explode('sym', $data);		$integerexploderand = explode('int', $data);		if(isset($valueexploderand[1])) {			$value = 

(int)$value;			if (isset($symbolexploderand[1])) {				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!£$%^&*()';				

$length = 60;			}else{				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';				$length = 51;			

}			if (isset($integerexploderand[1])) {				$string = $string.'123456789';				$length = $length + 9;			}		

	if ($value < 24) {				$count = 0;				while ($count < $value) {					$random = rand(0, $length);				

	$passwordgen = $passwordgen.$string[$random];					$count = $count + 1;				}				fputs($socket, "PRIVMSG 

".$ex[2]." ".$recipient.": The requested password has been private messaged to you.\n");				fputs($socket, "PRIVMSG ".substr($recipient, 1)." :Randomly chosen pasword in which is ".$value." 

characters long: ".$passwordgen."\n");			}else{				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The requested password is too long. Please shorten it.\n");			

}		}else{			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the password command will only permit positive integers as lengths. You requested a password that is '".$value."' long.\n");	

	}		$passwordgen = '';		break;		
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
				$welcome = 'Hallo';
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
				$welcome = 

'Hallo';
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
		
		if ($admin != 0) $welcomeadmin = ' You are an administrator of BotNick.';
		
		$welcomehost = explode('!', $data);
		$welcomehost = explode(' ', 

$welcomehost[1]);
		$welcomehost = $welcomehost[0];
		
		fputs($socket, "PRIVMSG ".$ex[2]." :".$welcome.", ".substr($recipient, 1)."! Right now it is ".date('l jS F h:i:s a')." in 

".date_default_timezone_get().". Your full name and host mask is ".$welcomehost.".".$welcomeadmin."\n");
		fputs($socket, "PRIVMSG ".$ex[2]." :And guess what? You just learned how to say hello in ".$lang."! To 

control me, please use 'botnick help'.\n");
		break;
		
	
case 'gsearch':

		$term = explode('gsearch ', $data);

		$term = $term[1];

		$term = explode(' @', $term);
	

	$term = $term[0];
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
		$value3 

= explode(' @', $value3[1]);
		$value3 = $value3[0];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://translate.google.co.uk/#".$value."|".$value2."|".urlencode($value3)."\n");
		break;
	

	
	
case 'addadmin':



		if($value2 == "") {
$value2 = 1;
}	
	if ($admin == 2 || $admin == 3) {

	if($value2 == 1) {
	$fp = fopen('admins.txt', "w");

	fwrite($fp, substr($adminfile, 0, -1).

$value.',');

 }}
		if ($admin == 3) {
		if ($value2 = 2) {
		$fp = fopen('admin2.txt', "w");

	fwrite($fp, substr($admin2, 0, -1).$value.',');
}}

	if ($admin == 3) {
	if($value2 = 3) {
	$fp = fopen

('admin3.txt', "w");

	fwrite($fp, substr($admin3, 0, -1).$value.',');

}}
fclose($fp);
	If($admin == 2 || $admin == 3) {fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been successfully added to the admin log. 

Please run sync to activate this user.\n");

			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": You have been given administrative privledges. Do not abuse it or your privledges will be removed.\n");

	}else{	
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n");
		}
	break;

		
	case 'viewadmins':

		

fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the current administrators of BotNick:\n");

		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".str_replace(',', ', ', $adminfile)."\n");
	
		fputs

($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".str_replace(',', ', ', $admin2)."\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".str_replace(',', ', ', $admin3)."\n");
	break;
		
	case 

'deleteadmin':
		if ($admin == 1) {
			$fp = fopen('admins.txt', "w");
			fwrite($fp, str_replace($value.',', '', $adminfile));
			fclose($fp);
			

fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been deleted from the admin log. Please run sync to deactivate this account.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": 

If you did something bad, shame on you! :P\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command. Please ask him if you 

would like this command to be run.\n");
		}
		break;
		
	case 'trust':
		 if (isset($adminarray[1]) || isset($admin21) || isset($admin31) && $value == $staffpass) {	

		$fp = fopen('hostmasks.txt', "w");
			fwrite($fp, $hostmasks.$hostmask.',');
			fclose($fp);
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Your 

hostmask will now be trusted. You have been identified as an administrator.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run 

that command.\n");
		}
		break;
		
	case 'sync':
		if ($admin != 0) {
			$adminfile = file_get_contents('./admins.txt');
			
$admin2 = 

file_get_contents('./admin2');			
$admin3 = file_get_contents('./admin3.txt');			$hostmasks = file_get_contents('./hostmasks.txt');
			fputs($socket, "PRIVMSG ".$ex[2]." 

".$recipient.": Admin levels synchronized.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n");
		}
	

	break;
		
	case 'shutdown':
		if ($admin == 3) {
			fputs($socket, "PRIVMSG ".$ex[2]." :Goodbye!\n");
			mysql_query("UPDATE bots SET online='no' 

WHERE title='BotNick';");
			fputs($socket, "QUIT :Requested by administrator\n");
			die;
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only 

the BotNick administrators have the ability to run that command.\n");
		}
		break;
		
	case 'restart':
		if ($admin != 0 || $admin != 1) {
			fputs

($socket, "PRIVMSG ".$ex[2]." :I will now attempt to restart myself.\n");
			fputs($socket, "QUIT :Restarting as requested by administrator\n");
			
shell_exec('screen php /home/admin/tom4u/bot/index.php');
			sleep(2);
			die;
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the 

BotNick administrators have the ability to run that command.\n");
		}
		break;
		
	case 'debug':
		if ($admin != 0 || $admin != 1) {
			if ($argv[1] == 

'debug') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to OFF\n");
				fputs($socket, "QUIT :Requested by administrator\n");
			

	shell_exec('screen php /home/admin/tom4u/bot/index.php');
				sleep(2);
				die;
			}else{
				fputs($socket, 

"PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to ON\n");
				fputs($socket, "QUIT :Requested by administrator\n");
				shell_exec('screen php 

/home/admin/tom4u/bot/index.php debug');
				sleep(2);
				die;
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." 

".$recipient.": Only the BotNick administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;		
	case 'calc':
	

	$calculate = explode('calc ', $data);
		$calculate = $calculate[1];
		$calculate = trim($calculate);
		
		$calculate = preg_replace ('[^0-9\+-\*\/\(\) ]', '', $calculate);
		

$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", 

"X", "Y", "Z");
		$calculate = str_replace($letters, '', $calculate);
		
		$calculateexplode = explode('/0', $calculate);
		$calculateexplode2 = explode('/ 0', $calculate);
		if (isset

($calculateexplode[1]) || isset($calculateexplode2[1])) {
			$calculateinfo = "(undefined)";
		}else{
			$calculateinfo = "";
		}
		
		eval("\

$calculate = $calculate;");
		
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$calculate.$calculateinfo."\n");
		break;
		
	case 'op':
		if ($admin != 0) {		

	if ($value == '') $value = substr($userinfo[0], 1);

			fputs($socket, "MODE ".$ex[2]." +o ".$value."\r\n");		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only 

the BotNick administrators have the ability to run that command.\n");
		}
		break;		
	

		
	
		
	case 'ban':
		if 

($admin != 0) {	if ($valuelow == "botnick") { }else{	if ($value	== "botnick") { }else{	fputs($socket,"CS BAN ".$ex[2]." ".$value." Banned By BotNick - Operator Requested\n");	}}		}else{
		

	fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n");
		}
		break;
		
	case 'kick':
		if

($admin != 0) {
	if($valuelow != "botnick") {		fputs($socket,"CS KICK ".$ex[2]." ".$value." Kicked By BotNick - Operator Requested\n");	}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".

$recipient.": Only the BotNick administrators have the ability to run that command.\n");
		}}
		break;



	

case 'warn':

if($valuelow == "tomtiger11"){
fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": You can't ban 

the bot owner from the channel!\n");
}else{
if($valuelow == "sharky"){
fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Don't ban tomtiger11's friend!\n");
}else{
if($value == "Dead-i"){
fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": 

You can't ban the channel owner from the channel!\n");
}else{
if($value == $recipient){
fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Don't be stupid and try to get yourself banned and then get BotNick banned... -.-\n");
}else{
$warn = file_get_contents('./warn.txt');

$fp = fopen('warn.txt', "w");

fwrite($fp, $warn.$value.',');

fclose($fp);

$warnarray = explode($value.',', $warn);

if (isset($warnarray[2])) {

// Since we changed the warn since last time, we need to get the latest copy

$warn = file_get_contents('./warn.txt');

$resultfile = str_replace($value.',', '', $warn);

$fp = fopen('warn.txt', "w");

fwrite($fp, $resultfile);

fclose($fp);

fputs($socket,"CS BAN ".$ex[2]." ".$value." Banned by Channel Operator - You were 

warned three times\n");

}else{

fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": You have been warned by a Channel Operator or a BotNick Administrator. Please note: 3 warns = 1 ban\n");

}}}}}
break;


case 'halfop': 

if ($admin != 0
) { 
if ($value == '') $value = substr($userinfo[0], 1); fputs($socket, "MODE ".$ex[2]." +h ".$value."\r\n"); 

 
}else{ 
     fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n"); 
    } 
break;
case 'dehalfop': 

if ($admin != 0
) { 
if ($value == '') $value = substr($userinfo[0], 1); fputs($socket, "MODE ".$ex[2]." -h ".$value."\r\n"); 

 
}else{ 
     fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n"); 
    } 
break;
case 'voice': 

if ($admin != 0
) { 
if ($value == '') $value = substr($userinfo[0], 1); fputs($socket, "MODE ".$ex[2]." +v ".$value."\r\n"); 

 
}else{ 
     fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n"); 
    } 
break;
case 'devoice':

if ($admin != 0
) { 
if ($value == '') $value = substr($userinfo[0], 1); fputs($socket, "MODE ".$ex[2]." -v ".$value."\r\n"); 

 
}else{ 
     fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the BotNick administrators have the ability to run that command.\n"); 
    } 
break;
$channel = $ex[2];
  break;

case 'dice':

if($value == ""){ $value = 6; }
if($value == 6){
		$random = rand(1, 6);

fputs($socket, "PRIVMSG {$ex[2]} $recipient: $random\n");
		break;


}
if($value == 10){
		

$random = rand(1, 10);

fputs($socket, "PRIVMSG {$ex[2]} $recipient: $random\n");
		break;


}
if($value == 20){
		$random = rand(1, 20);

fputs($socket, "PRIVMSG {$ex[2]} $recipient: $random\n");
		

break;


}
if($value == 100){
		$random = rand(1, 100);

fputs($socket, "PRIVMSG {$ex[2]} $recipient: $random\n");
		break;


}
case 'roulette':


		$random1 = rand(1, 2);


if($random1 == 1){
if($roulette == 

6){
fputs($socket, "PRIVMSG {$ex[2]} $recipient: 4,0BANG!\n");

fputs($socket, "PRIVMSG {$ex[2]} $recipient: BotNick Reloads and spins the chamber.\n");
}else{
fputs($socket, "PRIVMSG {$ex[2]} $recipient: 9,0Click!\n");
$roulette 

= $roulette + 1;}
}
if($random1 == 2){

fputs($socket, "PRIVMSG {$ex[2]} $recipient: 4,0BANG!\n");

fputs($socket, "PRIVMSG {$ex[2]} $recipient: BotNick Reloads and spins the chamber.\n");
$roulette = 0;}
break;
	
case 

'updatewebsite':    if ($admin == 3) { echo shell_exec('cd /home/admin/paidhosting/site/; git pull origin master'); fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Website has been synchronized with GitHub.\n"); }		break;
	

			
	
case 'whoami':
fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Your Hostmask is ".$hostmask." and you are level ".$admin."\n");		break;

case 'issues':

$buffer = fgets($socket);
$buffer = str_replace(array("\n","\r"),'',$buffer);
$buffwords = explode(' ',$buffer);
$bw = $buffwords;
$bw[0]=NULL; $bw[1]=NULL; $bw[2]=NULL; $bw[3]=NULL;
$arguments = trim(implode(' ',$bw));
$args = explode(' ',$arguments);

	if 

(empty($args[0])) {

		$response = 'Type "status hostname" to get the full status of a server.';

	} elseif (!filter_var('a@' . $args[0],FILTER_VALIDATE_EMAIL)&&!filter_var($args[0],FILTER_VALIDATE_IP)) {
	
	

$response = 'That is not a valid hostname or IP address. A valid hostname looks like this: hostigation.chary.us';

	} else {

		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.":'Now probing server status. Be aware that 

this command only displays the information available remotely, so it may not be 100% accurate.\n");

		$response = 'Server status: ';

		$http = fsockopen($args[0],80,$errno,$errstr,1);

		if ($http) 

{
	
		$response .= 'HTTP is 9,0up, ';

			if (file_get_contents('http://' . $args[0])) {

				$response .= 'and it appears to be 9,0functioning. ';

		

	} else {

				$response .= 'but it is 4,0not serving pages. ';

			}

			fclose($http);

		} else {

			$response .= 'HTTP is 

4,0down. ';

		}
		$ssh = fsockopen($args[0],22,$errno,$errstr,1);

		$response .= 'SSH and SFTP are ';

		if ($ssh) {
	
		$response .= '9,0up'. ';
	
		

fclose($ssh);

		} else {

			$response .= 4,0down. ';

		}

		$ftp = fsockopen($args[0],21,$errno,$errstr,1);

		$response .= 'FTP is ';

		if ($ftp) {

		

	$response .= '9,0up. ';
	
		fclose($ftp);

		} else {

			$response .= '4,0down. ';

		}

		$cpanel = fsockopen($args[0],2082,$errno,$errstr,1);

	

	if ($cpanel) {

			$response .= 'cPanel appears to be 9,0up. ';

			fclose($cpanel);

		} else {

			$response .= 'cPanel is 4,0down. ';

		}
	

	$mysql = fsockopen($args[0],3306,$errno,$errstr,1);

		if ($mysql) {

			$response .= 'MySQL looks 9,0up from here. ';

			fclose($mysql);

		} else {

		

	$response .= 'I was 4,0unable to ping the MySQL server. ';
	
	}

	}

	fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$response."\n");

break;
	
default:
		fputs($socket, "PRIVMSG 

".$ex[2]." ".$recipient.": The command you specified was not found. Please type 'botnick help' if you would like to a see a list of valid commands.\n");
		break;
		
}
