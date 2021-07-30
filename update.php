<?php

$hostname = $_GET["hostname"];

switch($hostname)
{
	case ("domain1.dyndns.example.de"):
		$Benutzer = "Benutzername";
		$Passwort = "Passwort";
		$Server = "Server";
		$Secure = false;
		$aktiv = true;
		break;
	
//	case ("eg.dyndns.gravos.eu"):
//		$Benutzer = "";
//		$Passwort = "";
//		$Server = "ddns.do.de";
//		$Secure = false;
//		$aktiv = false;
//		break;
	

	default:
	error_log ("Hostame nicht vorhanden : ".$hostname);
	break;
}

//echo $_SERVER["REMOTE_ADDR"];

/**** Die Abfrage ****/
$actual_ip = gethostbyname($hostname);
$IP = $_SERVER["REMOTE_ADDR"];

if ($aktiv) {
	if ($actual_ip <> $IP) {
		// Update String bauen
		if($Secure) $Update ='https://'; else $Update ='http://';
		$Update.=$Benutzer.':'.$Passwort;
		$Update.='@'.$Server.'/nic/update?hostname=';
		$Update.=$hostname.'&myip='.$IP;
		// CURL($Update);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Update);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$ERR = curl_exec($ch);
		curl_close($ch);
		unset($ch);
		// "Fehler"-Ausgabe
	//	echo ($ERR);
		//error_log ($ERR);
	} else {
		//$text = "IP-Adressen sind bereits identisch. - " . $actual_ip . " - " . $IP;
	//    echo ($text);
		//error_log ($text);
	}
}
else
{
	error_log ("Hostame nicht aktiv : ".$hostname);
}	

?>