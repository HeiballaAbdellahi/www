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

      $config = array(
      "digest_alg" => "sha512",
      "private_key_bits" => 384,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
      );

		$VI_KPR=openssl_pkey_new($config);

    // Extract the private key from $VI_KPR to $privKey
    openssl_pkey_export($VI_KPR, $privKey);

    // Extract the public key from $VI_KPR to $pubKey
    $pubKey = openssl_pkey_get_details($VI_KPR);
    $pubKey = $pubKey["key"];


			$statement = $link_db->prepare('INSERT INTO `db_vi` (`nom`, `prenom`, `password`, `email`, `date`, `VI_KPR`, `VI_KP`) VALUES(:nom,:prenom,:password,:email,:date,:VI_KPR,:VI_KP)');
			$statement->bindParam(":nom",$_POST['name']);
			$statement->bindParam(":prenom",$_POST['surname']);
			$statement->bindParam(":password",$_POST['password']);
			$statement->bindParam(":email",$_POST['email']);
			$statement->bindParam(":date",$_POST['date']);
			$statement->bindParam(":VI_KPR",$privKey);
			$statement->bindParam(":VI_KP",$pubKey);
			$statement->execute();

			$req = $link_db->prepare('SELECT `I` FROM `db_vi` WHERE nom=:nom and prenom=:prenom and password=:password');
      $req->execute(array('nom' => $_POST['name'],'prenom' => $_POST['surname'], 'password' => $_POST['password']));
			if($donnees = $req->fetch())
			echo "<h1>Vous avez inscrie avec succes</h1><br><h2>votre identifiant est : ". $donnees['I'] ."</h2>";
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
