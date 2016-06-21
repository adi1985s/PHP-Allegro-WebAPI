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

$limit = 10;

$sell = $client -> doMyAccount2( array(
    'sessionHandle' => $session_handle,
    'accountType' => 'sell',
    'offset' => 0,
    'itemsArray' => array(),
    'limit' => $limit
    )
);
echo "Ofert w kategorii Sprzedaję: ".$sell_count->myaccountItemsCount."<br><br>";
//print_r ( $sell->myaccountList->item[0] ); // - = pierwsza z ofert, 1 druga itp

?>

<table class="table table-striped">
    <tr><th>Check</th><th>Zdjęcie</th><th>Oferty</th><th>Cena</th><th>XXX</th></tr>

<?php
$items_arr = $sell->myaccountList->item;
foreach( $items_arr as $item ){
    
    $current = $item->myAccountArray->item;
    
                echo "<tr>";
                echo "<td><input type='checkbox'></td>"  ; 
                
                echo "<td><ul class='list-group'>";
                echo "<li class='list-group-item'>".$current[9]."</li>";     // title
                echo "<li class='list-group-item'>".$current[0]."</li>";     // id
                echo "</ul></td>";
                
                echo "<td><ul class='list-group'>";
if(!$current[2])echo "<li class='list-group-item'>Cena wywoławcza: ".$current[2]."</li>"  ; 
if(!$current[3])echo "<li class='list-group-item'>Cena minimalna: ".$current[3]."</li>"  ; 
if($current[28])echo "<li class='list-group-item'>Cena kup teraz: ".$current[4]."</li>"  ;
                echo "</ul></td>";
                
                echo "<td><ul class='list-group'>";
if(!$current[1])echo "<li class='list-group-item'>Cena wywoławcza".$current[1]."</li>";     // cena wywoławcza
                echo "<li class='list-group-item'>".$current[6]."</li>";     // czas rozpoczęcia
                echo "<li class='list-group-item'>".$current[7]."</li>";     // // czas zakończenia
                echo "</ul></td>";
                
                
                echo "<td><ul class='list-group'>";
                echo "<li class='list-group-item'>Sprzedano ".$current[17]." z ".$current[5]."</li>";   
                echo "<li class='list-group-item'>Sprzedano ".$current[21]." ".$current[22]."</li>";   // kupujący + punkty
                echo "</ul></td>";
    
                
                echo "<td>".$current[8]."</td>"  ; // highest bider
                echo "<td>".$current[10]."</td>" ; // liczba złożonych ofert kupna
    
                echo "<td>".$current[13]."</td>" ; // wybranych opcjach dodatkowych (więcej)
                echo "<td>".$current[14]."</td>" ; // maksymalna oferowana przez użytkownika
                echo "<td>".$current[15]."</td>" ; // maksymalna cena oferowana za przedmiot
    
                echo "<td>".$current[27]."</td>" ; // liczba osób obserwujących aukcję (lub NULL w przypadku braku obserwujących),
                
                echo "<td>".$current[33]."</td>" ; // liczba wyświetleń oferty,
                echo "<td>".$current[37]."</td>" ; // SA (1 - jest, 0 - nie_
                echo "</tr>";
                
}


?>
</table>      



<?php include 'includes/footer.php'; ?>