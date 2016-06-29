<?php

session_start();
require_once('wsdl.php');
include 'includes/header.php';
include 'helpers/metody_platnosci.php';

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
   'itemsIdArray' => array( $offer_id ),
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

// pobranie formularzy pozakupowych korzystając z ID transakcji 
foreach ($transaction_arr as $transaction_id) {
    $fodiz = $client -> doGetPostBuyFormsDataForSellers(array(
       'sessionId' => $session_handle,
       'transactionsIdsArray' => array($transaction_id)
       )
    );
    
    $fodiz_buyer_id = $fodiz -> postBuyFormData -> item ->postBuyFormBuyerId;
    if( $buyer_id == $fodiz_buyer_id ){
    
        $fodiz_tytul = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItTitle;
        $fodiz_l_kupionych = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealQuantity;
        $fodiz_data_sprzedazy = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealDate;
        $fodiz_cena_koncowa = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealFinalPrice;
        $fodiz_buyer_id = $fodiz -> postBuyFormData -> item ->postBuyFormBuyerId;
        
        $fodiz_buyer_msg = $fodiz -> postBuyFormData -> item->postBuyFormMsgToSeller;
        $fodiz_adress_street = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrStreet;
        $fodiz_adress_code = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrPostcode;
        $fodiz_adress_city = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrCity;
        $fodiz_adress_full_name = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrFullName;
        $fodiz_adress_phone = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrPhone;
        $fodiz_adress_date = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormCreatedDate; //data wypełnienia
        $fodiz_sposob_platnosci = $fodiz -> postBuyFormData -> item -> postBuyFormPayType; // Typ metody płatności (zgodny z PayU - pełną listę http://developers.payu.com/pl/introduction.html#introduction_paymenttypes ). Dodatkowo, w polu zwrócone mogą zostać także dwa inne typy: co (Checkout PayU) oraz ai (Raty PayU) a także trzy typy spoza PayU: collect_on_delivery (Płacę przy odbiorze), wire_transfer (Zwykły przelew - poza systemem PayU) oraz not_specified (dla postBuyFormSentBySeller = 1).
        $fodiz_sposob_dostawy = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentId ; // Identyfikator sposóbu dostawy (listę identyfikatorów sposobów dostawy uzyskać można za pomocą metody doGetShipmentData).
        $fodiz_wplacil = $fodiz -> postBuyFormData -> item -> postBuyFormPaymentAmount  ;
        $fodiz_login_kupujacego = $fodiz -> postBuyFormData->item->postBuyFormBuyerLogin;
    
    print_r( $fodiz ); 
    echo "<HR>";
    break;
    } // if end
    else {
        
        $fodiz_brak = '<div class="alert alert-warning">Użytkownik nie wypełnił formularza dostawy.</div>';
        
        // doGetPostBuyData - ogólne info o kupującym, jeśli nie wypełnił formularza dostawy
        $postBuyData = $client -> doGetPostBuyData(array( 
       'sessionHandle' => $session_handle,
       'itemsArray' => array( $offer_id ), 
       'buyerFilterArray' => array( $buyer_id )
            )
        );

        $fodiz_tytul = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItTitle;
        $fodiz_l_kupionych = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealQuantity;
        $fodiz_data_sprzedazy = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealDate;
        $fodiz_cena_koncowa = $fodiz -> postBuyFormData->item->postBuyFormItems->item->postBuyFormItDeals->item->dealFinalPrice;
        
        $fodiz_buyer_msg = "-";
        $fodiz_adress_street = "-";
        $fodiz_adress_code = "-";
        $fodiz_adress_city = "-";
        $fodiz_adress_full_name = "-";
        $fodiz_adress_phone = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormAdrPhone;
        $fodiz_adress_date = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentAddress -> postBuyFormCreatedDate; //data wypełnienia
        $fodiz_sposob_platnosci = $fodiz -> postBuyFormData -> item -> postBuyFormPayType; // Typ metody płatności (zgodny z PayU - pełną listę http://developers.payu.com/pl/introduction.html#introduction_paymenttypes ). Dodatkowo, w polu zwrócone mogą zostać także dwa inne typy: co (Checkout PayU) oraz ai (Raty PayU) a także trzy typy spoza PayU: collect_on_delivery (Płacę przy odbiorze), wire_transfer (Zwykły przelew - poza systemem PayU) oraz not_specified (dla postBuyFormSentBySeller = 1).
        $fodiz_sposob_dostawy = $fodiz -> postBuyFormData -> item -> postBuyFormShipmentId ; // Identyfikator sposóbu dostawy (listę identyfikatorów sposobów dostawy uzyskać można za pomocą metody doGetShipmentData).
        $fodiz_wplacil = $fodiz -> postBuyFormData -> item -> postBuyFormPaymentAmount  ;
        $fodiz_login_kupujacego = $fodiz -> postBuyFormData->item->postBuyFormBuyerLogin;
//todo - login z $postBuyData!!

    } // else end
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <?php if ( isset($fodiz_brak) ) { 
                echo $fodiz_brak; 
            }
            ?>

            <table class="table">
                
                <tr> <th>Tytuł oferty</th>               <td><?php echo $fodiz_tytul; ?></td> </tr>
                <tr> <th>Liczba sprzedanych</th>         <td><?php echo $fodiz_l_kupionych; ?></td>      </tr>
                <tr> <th>Cena</th>                       <td><?php echo $fodiz_cena_koncowa; ?> zł</td>    </tr>
                <tr> <th>Sposób dostawy</th>             <td><?php echo $fodiz_sposob_dostawy; ?> </td>    </tr>
                <tr> <th>Metoda płatności</th>           <td><?php echo payment_method_translate( $fodiz_sposob_platnosci ); ?> </td>    </tr>
                <tr> <th>Data wypełnienia formularza</th><td><?php echo $fodiz_adress_date; ?></td>    </tr>
                
                <tr> <th>Login kupującego</th>           <td><a href ="#"><?php echo $fodiz_login_kupujacego; ?> </a> </td>   </tr> <!--todo add user data lightbox in a href-->
                <tr> <th>Kupujący </th>                  <td><?php echo $fodiz_adress_full_name; ?></td>   </tr>
                <tr> <th>Adres dostawy </th>             <td><?php echo $fodiz_adress_street."<br>".$fodiz_adress_code." ".$fodiz_adress_city; ?></td>   </tr>
                <tr> <th>Telefon kupującego</th>         <td><?php echo $fodiz_adress_phone; ?></td>   </tr>
                <tr> <th>Data sprzedaży</th>             <td><?php echo $fodiz_data_sprzedazy; ?></td>   </tr>
                <tr> <th>Wiadomość od kupującego</th>    <td><?php echo $fodiz_buyer_msg; ?></td>   </tr>
              
            </table>
            
        </div>
    </div>
</div>





<?php include 'includes/footer.php'; ?>