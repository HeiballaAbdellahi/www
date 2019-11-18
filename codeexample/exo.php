<?php
$res = openssl_pkey_new();

// Get private key
openssl_pkey_export($res, $privkey);

// Get public key
$pubkey = openssl_pkey_get_details($res);
$pubkey = $pubkey["key"];
// var_dump($privkey);
// var_dump($pubkey);

// get some text from command line to work with
$tocrypt = 'hamza';

// some variables to work with
// $encryptedviaprivatekey = ""; //holds text encrypted with the private key
// $decryptedviapublickey = ""; // holds text which was decrypted by the public key after being encrypted with the private key, should be same as $tocrypt
// $encryptedviapublickey = ""; // holds text that was encrypted with the public key
// $decryptedviaprivatekey = ""; // holds text that was decrypted with the private key after being encrypted with the public key, should be the same as $tocrypt

openssl_private_encrypt($tocrypt, $encryptedviaprivatekey, $privkey);
echo $tocrypt . "->" . $encryptedviaprivatekey;
echo "\n\n";
openssl_public_decrypt($encryptedviaprivatekey, $decryptedviapublickey, $pubkey);
echo $encryptedviaprivatekey . "->" . $decryptedviapublickey;
echo "\n\n";

openssl_public_encrypt($tocrypt,$encryptedviapublickey, $pubkey);
echo $tocrypt . "->" . $encryptedviapublickey;
echo "\n\n";
openssl_private_decrypt($encryptedviapublickey, $decryptedviaprivatekey, $privkey);
echo $encryptedviapublickey . "->" . $decryptedviaprivatekey;
?>
