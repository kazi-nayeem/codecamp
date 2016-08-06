<?php
require_once 'db\connect.php';

$possEmailErr = false;
$email = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$stmt = $db->prepare('SELECT user_id,user_name FROM `user_table` WHERE user_email = ? AND password = ?;');
	$stmt->bind_param('ss', $email,$password);
	$email = $_POST["useremail"];
	$password = $_POST["userpassword"];
	$stmt->execute();
	$stmt->bind_result($userid,$name);
	$stmt->fetch();
	//echo $result, "    ", $name, "<br>";
	if($userid>0){
		session_start();
		$_SESSION["userid"] = $userid;
		$_SESSION["username"] = $name;
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'dashboard.php';
		header("Location: http://$host$uri/$extra");
		die();
	}else{
		$possEmailErr = true;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>CodeCamp Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
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

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form method="post" class="form-login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
		            <input type="text" name="useremail" class="form-control" value="<?php echo $email;?>" placeholder="User ID" autofocus>
		            <br>
		            <input type="password" name="userpassword" class="form-control" placeholder="Password">
		            <label class="checkbox">
		            	<?php if($possEmailErr) {?>
		            	<span class="pull-left help-block" style="color: red">
		                     User ID or Password is wrong
		                </span>
		                <?php } ?>
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		                </span>
		            </label>
		            <input class="btn btn-theme btn-block" type="submit" value="SIGN IN"></input>
		            
		            <hr>
		            
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="signup.php">
		                    Create an account
		                </a>
		            </div>
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg3.jpg", {speed: 500});
    </script>


  </body>
</html>
