<?php 
require 'function\formvalidation.php';
require_once 'db\connect.php';

$username = $password1 = $password2 = $useremail = "";
$allview = $usernameErr = $passwordErr = $useremailErr = $allview = $emailExist = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty($_POST["username"])){
		$usernameErr = true;
	}else{
		$username = formatInput($_POST["username"]);
		$usernameErr = nameErrCheck($username);
	}

	if(empty($_POST["password1"])){
		$passwordErr = true;
	}else{
		$password1 = formatInput($_POST["password1"]);
	}

	if(empty($_POST["password2"])){
		$passwordErr = true;
	}else{
		$password2 = formatInput($_POST["password2"]);
	}

	if($password1 != $password2) {
		$passwordErr = true;
	}

	if(empty($_POST["useremail"])){
		$useremailErr = true;
	}else{
		$useremail = formatInput($_POST["useremail"]);
		$useremailErr = emailErrCheck($useremail);
		//echo "email : ", $useremail;
	}

	$allview = ($usernameErr or $useremailErr or $passwordErr);

	if(!$allview){
		$stmt = $db->prepare('SELECT user_id FROM `user_table` WHERE user_email = ?;');
		$stmt->bind_param("s", $useremail);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		if($result>0){
			$allview = $useremailErr = $emailExist = true;
		}else{
			$stmt = $db->prepare('INSERT INTO `user_table` (`user_name`, `user_email`, `password`) VALUES (?, ?, ?);');
			$stmt->bind_param("sss", $name, $email, $pass);
			$name = $username;
			$email = $useremail;
			$pass = $password1;

			if($stmt->execute() == true){
				$last_id = $stmt->insert_id;
				session_start();
				$_SESSION["userid"] = $last_id;
				$_SESSION["username"] = $name;

				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$extra = 'update.php';
				header("Location: http://$host$uri/$extra");
				die();
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Dashboard">
   <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Sign Up</title>
    <!-- Bootstrap core CSS -->
   <link href="assets/css/bootstrap.css" rel="stylesheet">
   <!--external css-->
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
       
   <!-- Custom styles for this template -->
   <link href="assets/css/style.css" rel="stylesheet">
   <link href="assets/css/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
 </head>
<body>
	<section id="container" >
     <!-- *********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
     *********************************************************************************************************************************************************** -->
     <!--header start-->
     <header class="header black-bg">
           
            <!--logo start-->
            <a href="login.php" class="logo"><b>Camp Home</b></a>
            <!--logo end-->
          
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.php">Login</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->      
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h3 class="mb">Sign Up</h3>
                      <form class="form-horizontal style-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                          <!--user name input start-->                     
                          <div class="form-group <?php if($usernameErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="username" class="form-control" placeholder="Name" <?php if($allview) echo 'value="',$username,'"';?>>
                              </div>
                          </div>                          
                          <!--user name input end-->

                          <!--user email input start-->                     
                          <div class="form-group <?php if($useremailErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Email</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="useremail" class="form-control" placeholder="Email" <?php if($allview) echo 'value="',$useremail,'"';?>>
                                  <?php if($emailExist) {?>
                                  	<span class="help-block">Email alraedy register</span>
                                  <?php } ?>
                              </div>
                          </div>                          
                          <!--user email input end-->

                          <!--user password input start-->
                          <div class="form-group <?php if($passwordErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Password</label>
                              <div class="col-sm-10">
                                  <input type="password"  name="password1" class="form-control" placeholder="********">
                              </div>
                          </div>

                          <div class="form-group <?php if($passwordErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Re-enter Password</label>
                              <div class="col-sm-10">
                                  <input type="password"  name="password2" class="form-control" placeholder="********">
                              </div>
                          </div>
                          <!--user password input end-->

                          <div class="form-group">
                          	<label class="col-sm-2 col-sm-2 control-label"></label>
                          	<div class="col-sm-10">
                          		<input type="submit" class="btn btn-theme" value="signup"></input>
                          	</div>
                          </div>
                          
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
          	
          	    	
          	
		</section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <?php require 'component\footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>
	
	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>
	
	<!--custom checkbox & radio-->
	
	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
	
	
	<script src="assets/js/form-component.js"></script>    
    
    
 <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

 </script>
</body>
</html>