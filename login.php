<?php

session_start();
require_once('wsdl.php');
#header('location: index.php');

$country			  = 1;	 
$query_allegro_webapi = 3;
$allegro_login	      = trim( $_POST['user_login'] );
$allegro_pass	      = base64_encode( hash('sha256', trim( $_POST['user_password'] ), true))  ;
$allegro_key 		  = trim( $_POST['user_key'] );

$_SESSION['key']      = $allegro_key;

if ( isset($_POST['sandbox_check']) ){
	$_SESSION['sandbox_check'] = true;
	$_SESSION['wsdl'] = SANDBOX_WSDL;
} else {
	$_SESSION['wsdl'] = ALLEGRO_WSDL;	
}

try{
	$client                  = new SoapClient( $_SESSION['wsdl'] );
	$version                 = $client->doQuerySysStatus(array(
									'sysvar' => $query_allegro_webapi, 
									'countryId' => $country, 
									'webapiKey' => $allegro_key)
									);
	$_SESSION['verKey'] = $version->verKey;
	$session                 = $client->doLoginEnc(array(
								   'userLogin' => $allegro_login,
								   'userHashPassword' => $allegro_pass,
								   'countryCode' => 1,
								   'webapiKey' => $allegro_key,
								   'localVersion' => $_SESSION['verKey'])
									);
    $_SESSION['session_key'] = $session->sessionHandlePart;
    
    $_SESSION['logged']   = true;
    
    header('location: panel.php');
}
// log in failed ___________________________________________________________________
catch(SoapFault $error){
	 $_SESSION['error'] =  'Błąd '.$error->faultcode.': '. $error->faultstring."\n";
	 header('location: index.php');
}

?>

