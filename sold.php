<?php

session_start();
require_once('wsdl.php');
include 'includes/header.php'; 

?>

<h1 class="page-header">Sprzedane</h1>

<?php

$sell_count = $client -> doMyAccountItemsCount( array(
   'sessionHandle' => $session_handle,
   'accountType' => 'sold',
   'itemsArray' => array()
    )
);

$limit = 10;
$sell = $client -> doMyAccount2( array(
    'sessionHandle' => $session_handle,
    'accountType' => 'sold',
    'offset' => 0,
    'itemsArray' => array(),
    'limit' => $limit
    )
);
echo "Ofert w kategorii Sprzedaję: ".$sell_count->myaccountItemsCount."<br><br>";

?>

<table class="table">
    <tr><th>Check</th><th>Zdjęcie</th><th>Oferta</th><th>Cena</th><th>Czas trwania</th>
        <th>Sprzedano</th>
    </tr>

<?php
$items_arr = $sell->myaccountList->item;
foreach( $items_arr as $item ){
    
$current = $item->myAccountArray->item;
include('doMyAccount2.php');
    
    // get auction image
    $img = $client -> doGetItemsInfo(array(
       'sessionHandle' => $session_handle,
       'itemsIdArray' => array( $id ),
       'getDesc' => 0,
       'getImageUrl' => 1,
       'getAttribs' => 0,
       'getPostageOptions' => 0,
       'getCompanyInfo' => 0,
       'getProductInfo' => 0
    )) -> arrayItemListInfo->item->itemImages->item[0]->imageUrl;
    
// try{

//     $buyer_ = $client -> doGetBidItem2(array(
//       'sessionHandle' => $session_handle,
//       'itemId' => $id
//       )
//     )->biditemList->item;
    
    
//     print_r ( $buyer_ );
//     echo "<HR>";
// }

// catch (Exception $x){}

                    echo "<tr>";
                    echo "<td><input type='checkbox'></td>"  ; 
                    
                    // Obrazek
                    echo "<td><ul class='aList'>";
                    echo "<li class='aListItem'><img src ='".$img."' class ='img-thumbnail miniaturka'></li>";     // title
                    echo "</ul></td>";
                    
                    // Tytuł + id
                    echo "<td><ul class='aList'>";
if ($has_SA) echo "<li class='aListItem'><strong>".$title." SA</strong></li>";     // title with SA
else                echo "<li class='aListItem'><strong>".$title."</strong></li>";     // title    
                                  
                    echo "<li class='aListItem'><a href ='".$auction_path.$id."'>".$id."</a></li>";     // id
                    echo "</ul></td>";
                    
                    // Cena
                    echo "<td><ul class='aList'>";
if(!$cena_wywolawcza)echo "<li class='aListItem'><strong>Wywoławcza:</strong>&nbsp;".$cena_wywolawcza." zł</li>"  ; 
if(!$cena_minimalna) echo "<li class='aListItem'><strong>Minimalna:</strong>&nbsp".$cena_minimalna." zł</li>"  ; 
if(!$cena_obecna)    echo "<li class='aListItem'><strong>Obecna:</strong>&nbsp<span class='cena_obecna'>".$cena_obecna."</span> zł</li>"  ; 
if($has_kt)    echo "<li class='aListItem'><strong>Kup&nbspteraz:</strong>&nbsp<span class='cena_kt'>".$cena_kt."</span>&nbsp;zł</li>"  ;
                    echo "</ul></td>";
                
                    // Czas trwania
                    echo "<td><ul class='aList'>";
                    echo "<li class='aListItem'>".substr( $cz_rozp , 0, 10 )." - </li>";     // czas rozpoczęcia
                    echo "<li class='aListItem'>".$cz_zak."</li>";     // // czas zakończenia
      
                    echo "</ul></td>";

                    // Sprzedano
                    echo "<td><ul class='aList'>";
                    echo "<li class='aListItem'><span class='sprzedano'>".$sprzedano."</span> z ".$liczb_start."</li>"; // Sprzedano
                    
                    // Dropdown 
                    echo "<li class='aListItem'>";
                    echo "<div class='dropdown'><button class='btn btn-link' data-toggle='dropdown'><strong>Kupujący </strong> <span class='caret'></span></button>";
                    echo "<ul class='dropdown-menu aList'>";
                    try{
                        $lista_kupujacych = $client -> doGetBidItem2( array(
                           'sessionHandle' => $session_handle,
                           'itemId' => $id )) -> biditemList-> item
                           ;
                        
                        foreach ( $lista_kupujacych as $buyer){
                            if ( is_array($buyer -> item) ){ // jeśli w ofercie jest jeden kupujący, otrzymamy od razu tablicę
                            $buyer_id = $buyer->item[1];
                            $buyer_login = $buyer->item[2];
                            }
                            else{ // jeśli w ofercie jest więcej kupujących, otrzymany obiekt z tablicami
                            $buyer_id = $buyer->bidsArray->item[1];
                            $buyer_login = $buyer->bidsArray->item[2];
                            }
                            
                        echo "<li class='aListItem'><a href='fodiz.php?buyer_id=".$buyer_id."&offer_id=".$id."'>".$buyer_login."</a></li>";
                        }
                    } catch (Exception $e) {}    
                    echo "</ul></div>";
                    
                    echo "</li></ul></td>";
                    echo "</tr>";
            
}

?>

</table>      

<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--            <p class="text-center">-->
<!--                Wartość sprzedanych: <span id="wielkosc_sprzedazy"></span>-->
<!--            </p>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php include 'includes/footer.php'; ?>
<!--<script type="text/javascript" src="js/wielkosc_sprzedazy.js"></script>-->