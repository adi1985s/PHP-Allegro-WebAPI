<?php

session_start();
require_once('wsdl.php');
include 'includes/header.php'; ?>

<h1 class="page-header">Lista FID-ów</h1>

<?php
$list_arr = $client->doGetSellFormFieldsExt(array( 
                                    'countryCode' => 1,
                                    'localVersion' => 0,
                                    'webapiKey' => $_SESSION['key'] ) ) -> sellFormFields->item ;
print_r( $list[0] );

echo '<table class= "table table-striped" id="fid_table">';  
echo '<thead><tr class="t_head"> <th>Numer FIDa</th>   <th>Opis pola</th>  </tr></thead>';

    foreach ( $list_arr as $item) {
        
        print_r ( '<tr><td>'.$item->sellFormId.'</td>
                       <td>'.$item->sellFormTitle."</td>
                   </tr>");
    }
    
echo '</table>';

// Metoda pozwala na pobranie listy pól formularza sprzedaży dostępnych we wskazanym kraju. 
// Wybrane pola mogą następnie posłużyć np. do zbudowania i wypełnienia formularza 
// wystawienia nowej oferty z poziomu metody doNewAuctionExt.

?>

<?php include 'includes/footer.php'; ?>
