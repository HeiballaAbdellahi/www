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

			$req = $link_db->prepare('SELECT * FROM `co` WHERE password= :password and id= :id');
      $req->execute(array('password' => $_POST['password'], 'id' => $_POST['id']));
      if ($donnees = $req->fetch())
      {

				//decryptage des donnes avec cle privé co et decyptage des donnees avec le cle pblique de Vi validation et en fin cryptage avec cle public DE ,validation


        ?>
        <!-- Striped Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Les votes a verifier
                            <!-- <small>Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code></small> -->
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id Vi</th>
                                    <th>Nom Vi</th>
                                    <th>Prenom Vi</th>
                                    <th>Verification</th>
                                </tr>
                            </thead>
                          <tbody>
        <?php

        // selection des votes appartir de la table 'vote' puis decryptage et afiichage sous forme tableau
        $reqVote = $link_db->query('SELECT * FROM `vote` WHERE `checkVote`=false');
        while ($tupler = $reqVote->fetch()) {

          // decryptage avec le cle privé de CO
          openssl_private_decrypt($tupler['nomViCry'], $decryptedNom, $donnees['CO_KPR']);
          openssl_private_decrypt($tupler['prenomViCry'], $decryptedPrenom, $donnees['CO_KPR']);
          openssl_private_decrypt($tupler['idViCry'], $decryptedId, $donnees['CO_KPR']);
          openssl_private_decrypt($tupler['ViKpCry'], $decryptedKeyPublicVi, $donnees['CO_KPR']);

          // decryptage avec le cle public de Vi
          openssl_public_decrypt($decryptedNom, $nomVi, $decryptedKeyPublicVi);
          openssl_public_decrypt($decryptedPrenom, $prenomVi, $decryptedKeyPublicVi);
          openssl_public_decrypt($decryptedId, $idVi, $decryptedKeyPublicVi);

          $data=array('id'=>$idVi,'nom'=>$nomVi,'prenom'=>$prenomVi);
          // affichage des donnes sous forme tableau
          ?>

                                      <tr>
                                          <th scope="row"><?php echo $tupler['id'] ; ?></th>
                                          <td><?php echo $idVi; ?></td>
                                          <td><?php echo $nomVi ; ?></td>
                                          <td><?php echo $prenomVi; ?></td>
                                          <td><button type="button" class="envoi btn bg-blue waves-effect <?php echo $tupler['id'] ; ?>" data-id="<?php echo $tupler['id'] ; ?>" data-idvi="<?php echo $idVi; ?>" data-nomvi="<?php echo $nomVi ; ?>"  data-prenomvi="<?php echo $prenomVi ; ?> ">Verifier</button></td>
                                      </tr>

          <?php
        }

        ?>
                        </tbody>
                    </table>
                  </div>
                  </div>
                  </div>
                  </div>
                  <!-- #END# Striped Rows -->
        <?php


      }else{
				echo "<h1>Erreur de saisie des donnes.</h1>";
			}


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

<!-- ajax -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<script>
$(".envoi").on('click',function(){

      var idv = $(this).data('idvi');
      var nomvi = $(this).data('nomvi');
      var prenomvi = $(this).data('prenomvi');
      var id = $(this).data('id');
      // console.log(prenomvi);
      $.post("validation.php",
      {
       id :id,
       idV : idv ,
       nom : nomvi,
       prenom : prenomvi
     },
     function(data, status){
       // alert(data);
       if(data=="success"&&status=="success"){
         //modification buttons
         $("button."+id).fadeOut(function(){$("button."+id).after("<p>Verifié.</p>");});
       }
        else
        {
          $("button."+id).fadeOut(function(){$("button."+id).after("<p>Echec!</p>");});
        }
      }



     );
            });


</script>
