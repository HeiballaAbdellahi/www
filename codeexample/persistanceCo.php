<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	try
	{
		$link_db = new PDO('mysql:host=localhost;dbname=db_crypto;charset=utf8', 'root', '');


		if(isset($_POST['password'])){

      $config = array(
      "digest_alg" => "sha512",
      "private_key_bits" => 4096,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
      );
    // $config=array(
  	// 					'private_key_bits'=>1024,
  	// 					'private_key_type'=>OPENSSL_KEYTYPE_RSA,
    //         );

		$VI_KPR=openssl_pkey_new($config);

		// openssl_pkey_export_to_file($VI_KPR,'/path/to/privatekey',$_POST['password']);
    // openssl_pkey_export_to_file($VI_KPR,'tarikKey');

    // Extract the private key from $VI_KPR to $privKey
    openssl_pkey_export($VI_KPR, $privKey);

    // Extract the public key from $VI_KPR to $pubKey
    $pubKey = openssl_pkey_get_details($VI_KPR);
    $pubKey = $pubKey["key"];

    // Encrypt the data to $encrypted using the public key
    //  openssl_public_encrypt($data, $encrypted, $pubKey);

    // Decrypt the data using the private key and store the results in $decrypted
    //  openssl_private_decrypt($encrypted, $decrypted, $privKey);

		echo "<h1>le cle prive est </h1> <br> $privKey ";
    echo "<h1>le cle public est </h1> <br> $pubKey ";

			// a m'expliquer
			// $query = "UPDATE users SET name = :user_name WHERE id = :user_id";
			// VALUES ('1', 'trdydtry', 'srtyrsy', 'seryrsy', 'seryry', '2018-06-02', 'sertsert', 'sryrty');
			$statement = $link_db->prepare('INSERT INTO `de` (`nom`, `password`, `DE_KPR`, `DE_KP`) VALUES(:nom,:password,:VI_KPR,:VI_KP)');
			$statement->bindParam(":nom",$_POST['name']);
			$statement->bindParam(":password",$_POST['password']);
			$statement->bindParam(":VI_KPR",$privKey);
			$statement->bindParam(":VI_KP",$pubKey);
			$statement->execute();
		}
    else {
      echo"<h1>Aucune unformation</h1>";
    }

	}
	catch (PDOException $e)
	{
		$output = 'Error connecting: ' . $e->getMessage();
		echo $output;
		exit();
	}
?>
