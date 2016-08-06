<?php
require 'component\security.php';
require_once 'function\formvalidation.php'; 
require_once 'db\database.php';
require_once 'judge\uva.php';
require_once 'judge\codeforces.php';
require_once 'judge\vjudge.php';
require_once 'profileinfo\userinfo.php';


$username = $password1 = $password2 = "";
$allview = $usernameErr = $passwordErr = $allview = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty($_POST["password1"])){
    if(!empty($_POST["password2"]))
        $passwordErr = true;
  }else{
    $password1 = formatInput($_POST["password1"]);
  }

  if(empty($_POST["password2"])){
    if(!empty($_POST["password1"]))
        $passwordErr = true;
  }else{
    $password2 = formatInput($_POST["password2"]);

    if($password1 != $password2) {
      $passwordErr = true;
    }else{
        updateUserPassword($_SESSION["userid"],$password1);
    }
  }

  if(empty($_POST["username"])){
    $usernameErr = true;
  }else{
    $username = formatInput($_POST["username"]);
    $usernameErr = nameErrCheck($username);
    if(!$usernameErr){
        updateUserName($_SESSION["userid"],$username);
    }
  }

  if(empty($_POST["uvahandle"])){
      deleteUVAHandle($_SESSION["userid"]);
  }else{
      updateUserUVAHandle($_SESSION["userid"],$_POST["uvahandle"]);
  }

  if(empty($_POST["codeforceshandle"])){
      deleteCodeforcesHandle($_SESSION["userid"]);
  }else{
      updateUserCodeforcesHandle($_SESSION["userid"],$_POST["codeforceshandle"]);
  }

  if(empty($_POST["vjudgehandle"])){
      deleteVjudgeHandle($_SESSION["userid"]);
  }else{
      updateUserVjudgeHandle($_SESSION["userid"],$_POST["vjudgehandle"]);
  }

  $allview = ($usernameErr or $passwordErr);

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

    <title>Update</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <?php require 'component\topbar.php'; ?>

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <?php require 'component\sidebar.php'; ?>
      
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
                      <h3 class="mb">Update</h3>
                      <form class="form-horizontal style-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                          <!--user name input start-->                     
                          <div class="form-group <?php if($usernameErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="username" class="form-control" placeholder="Name" value="<?php if($allview) echo $username; else echo getUserName($_SESSION["userid"]);?>";>
                              </div>
                          </div>                          
                          <!--user name input end-->

                          <!--user uva input start-->                     
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">UVa Handle</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="uvahandle" class="form-control" placeholder="UVa Handle" value="<?php echo getUVAHandle($_SESSION["userid"]);?>";>
                              </div>
                          </div>                          
                          <!--user uva input end-->

                          <!--user codeforces input start-->                     
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Codeforces Handle</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="codeforceshandle" class="form-control" placeholder="Codeforces Handle" value="<?php echo getCodeforcesHandle($_SESSION["userid"]);?>";>
                              </div>
                          </div>                          
                          <!--user codeforces input end-->

                          <!--user vjudge input start-->                     
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Vjudge Handle</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="vjudgehandle" class="form-control" placeholder="Vjudge Handle" value="<?php echo getVjudgeHandle($_SESSION["userid"]);?>";>
                              </div>
                          </div>                          
                          <!--user vjudge input end-->

                          <!--user password input start-->
                          <div class="form-group <?php if($passwordErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">New Password</label>
                              <div class="col-sm-10">
                                  <input type="password"  name="password1" class="form-control" placeholder="********">
                              </div>
                          </div>

                          <div class="form-group <?php if($passwordErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Re-enter New Password</label>
                              <div class="col-sm-10">
                                  <input type="password"  name="password2" class="form-control" placeholder="********">
                              </div>
                          </div>
                          <!--user password input end-->

                          <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                              <input type="submit" class="btn btn-theme" value="Update"></input>
                              <button type="button" class="btn btn-warning"><a href="profile.php" style="color: white">Cancel</a></button>
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
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  
</body>
</html>