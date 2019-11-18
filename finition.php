<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Enregistrement</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <!-- <link href="css/themes/all-themes.css" rel="stylesheet" /> -->
</head>

<div style="padding-top: 50px"></div>

</div>
<div class="container">


<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	try
	{


		$link_db = new PDO('mysql:host=localhost;dbname=db_crypto;charset=utf8', 'root', '');


		if(isset($_POST['password'])){

			$req = $link_db->prepare('SELECT * FROM `db_vi` WHERE password= :password and I= :id and voter=0');
      $req->execute(array('password' => $_POST['password'], 'id' => $_POST['id']));
      if ($donnees = $req->fetch())
      {

				//cryptage des donnes avec cle privé utilisateur puis ajoute cle publique utilisateur cyptage des donnees avec le cle pblique de CO et en fin cryptage des vote avec cle public DE

				//cryptage des donnes avec cle privé utilisateur
				openssl_private_encrypt($donnees['nom'], $encryptedNom, $donnees['VI_KPR']);
				openssl_private_encrypt($donnees['prenom'], $encryptedPrenom, $donnees['VI_KPR']);
				openssl_private_encrypt($donnees['I'], $encryptedId, $donnees['VI_KPR']);

				// echo $donnees['nom'].'->'.$encryptedNom.'<br>';

				//recuperation du cle publique CO
				$reponse = $link_db->query('SELECT `CO_KP` FROM `CO` WHERE id=1');
				if($donneesCo = $reponse->fetch())
				$publicKeyCo=$donneesCo['CO_KP'];

				//cyptage des donnees avec le cle publique de CO
				openssl_public_encrypt($encryptedNom, $encryptedNomCo, $publicKeyCo);
				openssl_public_encrypt($encryptedPrenom, $encryptedPrenomCo, $publicKeyCo);
				openssl_public_encrypt($encryptedId, $encryptedIdCo, $publicKeyCo);
				openssl_public_encrypt($donnees['VI_KP'], $encryptedKeyPublicVi, $publicKeyCo);

				// echo $donnees['nom'].'->'.$encryptedNomCo.'<br>';
				// echo $donnees['prenom'].'->'.$encryptedPrenomCo.'<br>';
				// echo $donnees['I'].'->'.$encryptedIdCo.'<br>';
				// echo $donnees['VI_KP'].'->'.$encryptedKeyPublicVi.'<br>';

				//recuperation du cle publique DE
				$reponse = $link_db->query('SELECT `DE_KP`,`DE_KPR` FROM `DE` WHERE id=1');
				if($donneesDe=$reponse->fetch())
				$publicKeyDe=$donneesDe['DE_KP'];

				//cryptage le vote avec cle public DE
				openssl_public_encrypt($_POST['vote'], $encryptedVoteDe, $publicKeyDe);

				//signature de 'vote' crypter par le cle privé de VI
				openssl_sign ( $encryptedVoteDe , $signature , $donneesDe['DE_KPR'] );


				// echo $_POST['vote'].'->'.$encryptedVoteDe.'<br>';


				//insertion des donnes dans la table vote avec des donnes crypter
				$statement = $link_db->prepare('INSERT INTO `vote`(`idViCry`, `nomViCry`, `prenomViCry`, `ViKpCry`, `voteCry`,`signature`) VALUES (:id,:nom,:prenom,:VI_KP,:vote,:signature)');

				$statement->bindParam(":id",$encryptedIdCo);
				$statement->bindParam(":nom",$encryptedNomCo);
				$statement->bindParam(":prenom",$encryptedPrenomCo);
				$statement->bindParam(":VI_KP",$encryptedKeyPublicVi);
				$statement->bindParam(":vote",$encryptedVoteDe);
				$statement->bindParam(":signature",$signature);
				$statement->execute();

				$reponse=$link_db->prepare('UPDATE `db_vi` SET `voter`=1 WHERE password=:password and I=:id');
        $reponse->execute(array('password' => $_POST['password'], 'id' => $_POST['id']));

				echo "<h1>Merci pour votre vote!</h1>";

				 // echo "<h1>Merci pour votre vote.</h1>";
				// openssl_public_encrypt($data, $encrypted, $pubKey);
				// openssl_public_encrypt($data, $encrypted, $pubKey);

      }else{
				echo "<h1>Vous avez voté deja!</h1>";
			}

      // $config = array(
      // "digest_alg" => "sha512",
      // "private_key_bits" => 1024,
      // "private_key_type" => OPENSSL_KEYTYPE_RSA,
      // );
    // $config=array(
  	// 					'private_key_bits'=>1024,
  	// 					'private_key_type'=>OPENSSL_KEYTYPE_RSA,
    //         );

		// $VI_KPR=openssl_pkey_new($config);

		// openssl_pkey_export_to_file($VI_KPR,'/path/to/privatekey',$_POST['password']);
    // openssl_pkey_export_to_file($VI_KPR,'tarikKey');

    // Extract the private key from $VI_KPR to $privKey
    // openssl_pkey_export($VI_KPR, $privKey);

    // Extract the public key from $VI_KPR to $pubKey
    // $pubKey = openssl_pkey_get_details($VI_KPR);
    // $pubKey = $pubKey["key"];

    // Encrypt the data to $encrypted using the public key
    //  openssl_public_encrypt($data, $encrypted, $pubKey);

    // Decrypt the data using the private key and store the results in $decrypted
    //  openssl_private_decrypt($encrypted, $decrypted, $privKey);

		// echo "<h1>le cle prive est </h1> <br> $privKey ";
    // echo "<h1>le cle public est </h1> <br> $pubKey ";

			// a m'expliquer
			// $query = "UPDATE users SET name = :user_name WHERE id = :user_id";
			// VALUES ('1', 'trdydtry', 'srtyrsy', 'seryrsy', 'seryry', '2018-06-02', 'sertsert', 'sryrty');





			// $statement = $link_db->prepare('INSERT INTO `db_vi` (`nom`, `prenom`, `password`, `email`, `date`, `VI_KPR`, `VI_KP`) VALUES(:nom,:prenom,:password,:email,:date,:VI_KPR,:VI_KP)');
			// $statement->bindParam(":nom",$_POST['name']);
			// $statement->bindParam(":prenom",$_POST['surname']);
			// $statement->bindParam(":password",$_POST['password']);
			// $statement->bindParam(":email",$_POST['email']);
			// $statement->bindParam(":date",$_POST['date']);
			// $statement->bindParam(":VI_KPR",$privKey);
			// $statement->bindParam(":VI_KP",$pubKey);
			// $statement->execute();
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
	// $config1 = array(
	// "digest_alg" => "sha512",
	// "private_key_bits" => 4096,
	// "private_key_type" => OPENSSL_KEYTYPE_RSA,
	// );
	//
	//
	//
	//
	//
	//
	// $config = array(
	// "digest_alg" => "sha512",
	// "private_key_bits" => 384,
	// "private_key_type" => OPENSSL_KEYTYPE_RSA,
	// );
	//
	// $VI_KPR=openssl_pkey_new($config);
	// $co=openssl_pkey_new($config1);
	//
	// // Extract the private key from $VI_KPR to $privKey
	// openssl_pkey_export($VI_KPR, $privKey);
	// openssl_pkey_export($co, $privKeyCo);
	// // Extract the public key from $VI_KPR to $pubKey
	// $pubKey = openssl_pkey_get_details($VI_KPR);
	// $pubKey = $pubKey["key"];
	// $pubKeyCo = openssl_pkey_get_details($co);
	// $pubKeyCo = $pubKeyCo["key"];
	//
	// // Decrypt the data using the private key and store the results in $decrypted
	//  openssl_private_encrypt($donnees['nom'], $encrypted, $privKey);
	//
	// // Encrypt the data to $encrypted using the public key
	// $encryptedP='';
	//  openssl_public_encrypt($pubKey, $encryptedP, $pubKeyCo);
	//
	//
	// echo "<h1>cryptage 1 </h1> <br> $pubKey ";
	// echo "<h1>cryptage 2 </h1> <br> $encryptedP ";
	//
	// // Decrypt the data using the private key and store the results in $decrypted
	// openssl_private_decrypt($encryptedP, $decrypted, $privKeyCo);
	//
	// // openssl_public_decrypt($decrypted, $decrypted1, $pubKey);
	//
	// echo "<h1>decryptage 1 </h1> <br> $decrypted ";
	// // echo "<h1>decryptage 2 </h1> <br> $decrypted1 ";

?>

</div>
<!-- Jquery Core Js -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<!-- <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script> -->

<!-- Jquery Validation Plugin Css -->
<script src="plugins/jquery-validation/jquery.validate.js"></script>

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<!-- Sweet Alert Plugin Js -->
<script src="../../plugins/sweetalert/sweetalert.min.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="plugins/node-waves/waves.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/form-validation.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
