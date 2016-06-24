<?php

session_start();
require_once('wsdl.php');
include 'includes/header.php';

$buyer_id = $_GET['buyer_id'];
$offer_id = $_GET['offer_id'];

?>

<h1 class="page-header">FODIZ</h1>

<?php

// Konwersja ID transakcji na tablicę (w przypadku jednego numeru) lub przepisanie
// tablicy transacions_ids do transacion_arr, aby możliwa była iteracja na wyniku ten funkcji
$transaction_arr = array();
$transaction_ids = $client -> doGetTransactionsIDs(array(
   'sessionHandle' => $session_handle,
   'itemsIdArray' => array($offer_id ),
   'userRole' => 'seller'
    )
) -> transactionsIdsArray -> item;

if ( ! is_array ($transaction_ids) ){
   array_push($transaction_arr, $transaction_ids);
}
else{
    foreach ($transaction_ids as $x) {
        array_push($transaction_arr, $x);
    }
}

print_r( $transaction_arr);

// pobranie formularzy pozakupowych korzystając z ID transakcji 
foreach ($transaction_arr as $transaction_id) {
    $fodiz = $client -> doGetPostBuyFormsDataForSellers(array(
       'sessionId' => $session_handle,
       'transactionsIdsArray' => array($transaction_id)
       )
    );
    print_r( $fodiz );
    
}

?>

<?php include 'includes/footer.php'; ?>