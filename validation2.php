<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

if(isset($_POST['clePR'])&&isset($_POST['signature'])&&isset($_POST['vote'])){

    //verfification de signature avec la cle privé de DE
      if(openssl_verify ( $_POST['vote'] , $_POST['signature'] , $_POST['clePR']))
      {
      // decryptage avec le cle privé de DE
      openssl_private_decrypt($tupler['voteCry'], $decryptedVote, $_POST['clePR']);
      echo "success";
      }else{
				echo "faild";
        // $modifier=$link_db->prepare('UPDATE `vote` SET `checkVote`=2 WHERE id=:id');
        // $modifier->execute(array('id' => $_POST['id']));
			}
	}else {
    echo"erreur";
  }
 ?>
