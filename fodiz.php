<?php

session_start();
require_once('wsdl.php');
include 'includes/header.php'; 

?>

<h1 class="page-header">Sprzedaję</h1>

<?php

$buyer_id = $_GET['buyer_id'];
echo $buyer_id;

?>

<?php include 'includes/footer.php'; ?>