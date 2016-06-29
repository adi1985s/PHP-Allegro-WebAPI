<?php

function payment_method_translate( $x ) {
    
    switch ( $x ){
        
case "m":
        echo'mTransfer - mBank';
        break;
case "mtex":
        echo'mTransfer mobilny - mBank';
        break;
case "w":
        echo'BZWBK - Przelew24';
        break;
case "o":
        echo 'Pekao24Przelew - Bank Pekao';
        break;
case "i":
        echo 'Płacę z Inteligo';
        break;
case "p":
        echo 'Płać z iPKO';
        break;
case "pkex":
        echo 'PayU Express Bank Pekao';
        break;
case "g":
        echo 'Płać z ING';
        break;
case "gbx":
        echo 'Płacę z Getin Bank';
        break;
case "gbex":
        echo 'GetIn Bank PayU Express';
        break;
case "nlx":
        echo 'Płacę z Noble Bank';
        break;
case "nlex":
        echo 'Noble Bank PayU Express';
        break;
case "ib":
        echo 'Paylink Idea - IdeaBank';
        break;
case "l":
        echo 'Credit Agricole';
        break;
case "as":
        echo 'Płacę z T-mobile Usługi Bankowe dostarczane przez Alior Bank';
        break;
case "exas":
        echo 'PayU Express T-mobile Usługi Bankowe';
        break;
case "u":
        echo 'Eurobank';
        break;
case "ab":
        echo 'Płacę z Alior Bankiem';
        break;
case "exab":
        echo 'PayU Express z Alior Bankiem';
        break;
case "ps":
        echo 'Płacę z PBS';
        break;
case "wm":
        echo 'Przelew z Millennium';
        break;
case "h":
        echo 'Przelew z BPH';
        break;
case "wd":
        echo 'Przelew z Deutsche Banku';
        break;
case "wc":
        echo 'Przelew z Citi Handlowego';
        break;
case "bo":
        echo 'Płać z BOŚ';
        break;
case "bnx":
        echo 'Płacę z BNP Paribas';
        break;
case "bnex":
        echo 'BNP Paribas PayU Express';
        break;
case "orx":
        echo 'Płacę z Orange';
        break;
case "orex":
        echo 'PayU Express Orange';
        break;
case "c":
        echo 'Karta kredytowa';
        break;
case "b":
        echo 'Przelew bankowy';
        break;
case "pu":
        echo 'Konto PayU. Więcej informacji o koncie PayU znajduje się w sekcji "Konto PayU"';
        break;
case "ai":
        echo 'Raty PayU';
        break;
case "t":
        echo 'Płatność testowa';
        break;
        
    }
    
}

?>