<?php

session_start();
require_once('wsdl.php');

if(!isset($_SESSION['logged']))
    header('location: index.php');
    
    $version_key     = $_SESSION['verKey'];
    $session_handle  = $_SESSION['session_key']; 
    
	$client = new SoapClient( $_SESSION['wsdl'] ); // new WSDL
	
  $user = $client -> doGetMyData(array('sessionHandle' => $session_handle));
  $username = $user->userData->userLogin;
   


?>

<?php include 'includes/header.php'; ?>

          <h1 class="page-header">Dashboard</h1>

<?php include 'includes/footer.php'; ?>