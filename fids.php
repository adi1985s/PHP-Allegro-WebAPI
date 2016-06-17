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

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>API Dashboard</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Allegro API <?php if($_SESSION['sandbox_check'] == true) echo Sandbox ?> </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><?php echo $username ?> </a></li>
            <li><a href="logout.php">Wyloguj</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search..." id="search_field">
          </form>
        </div>
      </div>
    </nav>

  <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="panel.php">Panel</a></li>
            <li><a href="sell.php">Sprzedaję</a></li>
            <li><a href="#">Analytics</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li  class="active"><a href="fids.php">Lista FID-ów</a></li>
            <li><a href="">Nav item again</a></li>

          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
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


        </div>
      </div>
    </div>

    
    <script type="text/javascript" src="js/jquery3.js"></script>
    <script type="text/javascript" src="js/fid_search.js"></script>
    </body>
</html>