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
<?php

$sell_count = $client -> doMyAccountItemsCount( array(
   'sessionHandle' => $session_handle,
   'accountType' => 'sell',
   'itemsArray' => array()
    )
);

$sell = $client -> doMyAccount2( array(
    'sessionHandle' => $session_handle,
    'accountType' => 'sell',
    'offset' => 0,
    'itemsArray' => array(),
    'limit' => 10
    )
);
echo "Ofert w kategorii Sprzedaję: ".$sell_count->myaccountItemsCount."<br><br>";

print_r ($sell);
echo "<br><hr><br>";

print_r ( $sell->myaccountList->item[0] ); // - = pierwsza z ofert, 1 druga itp

?>

<?php include 'includes/footer.php'; ?>