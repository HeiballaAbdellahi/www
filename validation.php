<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

if(isset($_POST['idV'])&&isset($_POST['nom'])&&isset($_POST['prenom'])){

  try
	{
		$link_db = new PDO('mysql:host=localhost;dbname=db_crypto;charset=utf8', 'root', '');

			$req = $link_db->prepare('SELECT * FROM `db_vi` WHERE nom=:nom and prenom=:prenom and I=:idV');
      $req->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'], 'idV' => $_POST['idV']));
      if ($donnees = $req->fetch())
      {
        $reponse=$link_db->prepare('UPDATE `db_vi` SET `voter`=1 WHERE nom=:nom and prenom=:prenom and I=:idV');
        $reponse->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'idV' => $_POST['idV']));
        echo "success" ;
        $modifier=$link_db->prepare('UPDATE `vote` SET `checkVote`=1 WHERE id=:id');
        $modifier->execute(array('id' => $_POST['id']));
      }else{
				echo "faild";
        $modifier=$link_db->prepare('UPDATE `vote` SET `checkVote`=2 WHERE id=:id');
        $modifier->execute(array('id' => $_POST['id']));
			}


		}

    catch (PDOException $e)
    {
      $output = 'Error connecting: ' . $e->getMessage();
      echo $output;
      exit();
    }

	}else {
    echo"erreur";
  }
 ?>
