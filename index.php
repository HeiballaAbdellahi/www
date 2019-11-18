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



<!-- Basic Validation -->
<div style="padding-top: 50px"></div>

</div>
<div class="container">


<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
						<div class="header">
								<h2> Inscription sur les listes électorales</h2>
								<!-- <ul class="header-dropdown m-r--5">
										<li class="dropdown">
												<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
														<i class="material-icons">more_vert</i>
												</a>
												<ul class="dropdown-menu pull-right">
														<li><a href="javascript:void(0);">Action</a></li>
														<li><a href="javascript:void(0);">Another action</a></li>
														<li><a href="javascript:void(0);">Something else here</a></li>
												</ul>
										</li>
								</ul> -->
						</div>
						<div class="body">
								<form id="form_validation" method="POST"  action="info.php">
										<div class="form-group form-float">
												<div class="form-line">
														<input type="text" class="form-control" name="name" required>
														<label class="form-label">Name</label>
												</div>
										</div>
										<div class="form-group form-float">
												<div class="form-line">
														<input type="text" class="form-control" name="surname" required>
														<label class="form-label">Surname</label>
												</div>
										</div>
										<div class="form-group form-float">
												<div class="form-line">
														<input type="email" class="form-control" name="email" required>
														<label class="form-label">Email</label>
												</div>
										</div>
										<div class="form-group form-float">
												<div class="form-line">
														<input type="text" class="form-control" name="date" required>
														<label class="form-label">Date</label>
												</div>
												<div class="help-info">YYYY-MM-DD format</div>
										</div>
										<!-- <div class="form-group">
												<input type="radio" name="gender" id="male" class="with-gap">
												<label for="male">Male</label>

												<input type="radio" name="gender" id="female" class="with-gap">
												<label for="female" class="m-l-20">Female</label>
										</div>
										<div class="form-group form-float">
												<div class="form-line">
														<textarea name="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
														<label class="form-label">Description</label>
												</div>
										</div> -->
										<!-- <div class="form-group form-float">
												<div class="form-line">
														<input type="password" class="form-control" name="password" required>
														<label class="form-label">Password</label>
												</div>
										</div> -->
										<div class="form-group form-float">
												<div class="form-line">
														<input type="password" class="form-control" name="password" id="password" required>
														<label class="form-label">Password*</label>
												</div>
										</div>
										<div class="form-group form-float">
												<div class="form-line">
														<input type="password" class="form-control" name="confirm" required>
														<label class="form-label">Confirm Password*</label>
												</div>
										</div>
										<!-- <div class="form-group">
												<input type="checkbox" id="checkbox" name="checkbox">
												<label for="checkbox">I have read and accept the terms</label>
										</div> -->
										<button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
								</form>
						</div>
				</div>
		</div>
</div>

<!-- #END# Basic Validation -->

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
