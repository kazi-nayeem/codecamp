<?php 
require_once '..\component\security.php';
require_once '..\db\database.php';
require_once '..\profileinfo\userinfo.php';
require_once '..\function\formvalidation.php';
require_once '..\judge\uva.php';
require_once '..\judge\codeforces.php';
//require 'operation\movetodashboard.php';
require 'operation\courseinfo.php';
require 'operation\contest.php';

if(!isset($_GET["course"])){
  require 'operation\movetodashboard.php';
}

$course_id = $_GET["course"];

$currentStudent = 0;

if(!isset($_GET["student"])){
  $currentStudent = $_SESSION["userid"];
}else{
  $currentStudent = $_GET["student"];
}

if(is_null(getCourseEnrollID($course_id,$currentStudent))){
  require 'operation\movetodashboard.php';
}

$canUnregister = (($currentStudent == $_SESSION["userid"]) or($_SESSION["userid"] == getCourseOwnerId($course_id)));


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

    <title>Course Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">

    <script src="../assets/js/chart-master/Chart.js"></script>
    
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
      <?php require '..\component\topbar.php'; ?>

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <?php require '..\component\sidebar.php'; ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
        <?php if($canUnregister == true){ ?>
        <div class="row mt">
          <div class="col-lg-12">
            <button type="button" class="btn btn-danger"><a style="color: white" href="operation/deletestudent.php?course=<?php echo $course_id."&student=".$currentStudent; ?>">Unregister</a></button>
          </div>
        </div>
        <?php } ?>
          <div class="row mt">
              <div class="col-lg-12">
                  <!-- course info start-->
                 <div class="white-panel pn">
                  <div class="white-header">
                    <h5><b>COURSE INFORMATION<b></h5>
                  </div>
                  <p><b><?php echo getCourseTitle($course_id);?></b></p>
                  <div class="row">
                    <div class="col-md-6">
                      <p class="small mt">Course ID</p>
                      <p><?php echo $course_id; ?></p>
                    </div>
                    <div class="col-md-6">
                      <p class="small mt">Course Owner</p>
                      <p><?php echo getUserName(getCourseOwnerId($course_id)); ?></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <p class="small mt">Registration ID</p>
                      <p><?php echo getCourseEnrollID($course_id,$currentStudent); ?></p>
                    </div>
                    <div class="col-md-6">
                      <p class="small mt">Student Name</p>
                      <p><?php echo getUserName($currentStudent) ?></p>
                    </div>
                  </div>
                </div>
                <!-- course info end-->
                
              </div><!-- col-lg-12-->       
            </div><!-- /row -->              
            
            <?php $viewContentFor = $currentStudent;
            require 'component\studentcontesttable.php';
            require '..\component\maincontent.php'; ?>

        </section>
    </section>

      <!--main content end-->
      <!--footer start-->
      		<?php require '..\component\footer.php'; ?>
      <!--footer end-->
     
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="../assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="../assets/js/sparkline-chart.js"></script>    
	<script src="../assets/js/zabuto_calendar.js"></script>	
	
	
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