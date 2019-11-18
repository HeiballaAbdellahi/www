<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	try
	{
		$link_db = new PDO('mysql:host=localhost;dbname=DB_Crypto;charset=utf8', 'root', '');
		

		if($_POST){

		$VI_KPR=openssl_pkey_new(array(
						'private_key_bits'=>1024,
						'private_key_type'=>OPENSSL_KEYTYPE_RSA,
						));
		openssl_pkey_export_to_file($VI_KPR,'/path/to/privatekey',$_POST['password']);

		echo "le cle est",$VI_KPR;
		}
		
		if($_POST){
			//$query = "UPDATE users SET name = :user_name WHERE id = :user_id";
			$statement = $link_db->prepare('INSERT INTO DB_VI(nom,prenom,password,email,date,VI_KPR,VI_KP) VALUES(:nom,,:prenom,:password,:email,:date,:VI_KPR,:VI_KP)');
			$statement->bindParam(":nom",$_POST['nom']);
			$statement->bindParam(":prenom",$_POST['prenom']);
			$statement->bindParam(":password",$_POST['password']);
			$statement->bindParam(":email",$_POST['email']);
			$statement->bindParam(":date",$_POST['date']);
			$statement->bindParam(":VI_KPR",$_POST['VI_KPR']);
			$statement->bindParam(":VI_KP",$_POST['VI_KP']);
			$statement->execute();
		}

	}
	catch (PDOException $e)
	{
		$output = 'Error connecting: ' . $e->getMessage();
		echo $output;
		exit();
	}
?>
<html>
<head>
</head>
<body>
<h1>  inscription sur les listes électorales </h1>
<form method="post">
	<label>Nom: <input type="text" name="nom"/></label><br/>
	<label>Prenom: <input type="text" name="prenom"/></label><br/>
	<label>Mot de passe: <input type="password" name="password"/></label><br/>
	<label>date: <input type="date" name="date"/></label><br/>
	<label>Adresse e-mail: <input type="text" name="email"/></label><br/>
	<input type="submit" value="M'inscrire"/>
</form>



</body>
</html>
