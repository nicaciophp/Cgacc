<?php

function criptografa($acao, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = "1ndFaemAoofjhdn2a";
    $secret_iv = "4ZRsC8Ad9hqhnZLB";
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $acao == 'crip' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $acao == 'decrip' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

/*$plain_txt = $string;
echo  "Texto puro: $plain_txt <br>";

$encrypted_txt = criptografa('crip', $plain_txt);
echo "Encrypted= " .$encrypted_txt. "<br>";

$decrypted_txt = criptografa('decrip', $encrypted_txt);
echo "Decrypted=" .$decrypted_txt. "<br>";

if ( $plain_txt === $decrypted_txt ) echo "SUCCESS";
else echo "FAILED";*/
?>