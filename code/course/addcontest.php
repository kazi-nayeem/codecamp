<?php 
require_once '..\component\security.php';
require_once '..\db\database.php';
require_once '..\profileinfo\userinfo.php';
require_once '..\function\formvalidation.php';
//require 'operation\movetodashboard.php';
require 'operation\courseinfo.php';
require 'operation\contest.php';

if(!isset($_GET["course"])){
  require 'operation\movetodashboard.php';
}

$course_id = $_GET["course"];

if($_SESSION["userid"] != getCourseOwnerId($course_id)){
  require 'operation\movetodashboard.php';
}

$contest_title = "";
$no_of_problem = 0;
$contest_date = "";
$contest_titleErr = $contest_dateErr = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //echo $_POST["contesttitle"];
    //echo $_POST["noofproblem"];
    //echo $_POST["contestdate"];
    if(empty($_POST["contesttitle"])){
      $contest_titleErr = true;
    }else{
      $contest_title = formatInput($_POST["contesttitle"]);
    }
    $no_of_problem = (int) $_POST["noofproblem"];
    if(empty($_POST["contestdate"])){
      $contest_dateErr = true;
    }else{
      $contest_date = $_POST["contestdate"];
    }
    //var_dump($contest_date);
   // var_dump($contest_title);
    //var_dump($no_of_problem);

    $allView = ($contest_dateErr or $contest_titleErr);
    if(!$allView){
      $contest_id = addNewContest($course_id,$contest_title,$contest_date,$no_of_problem);
      if($contest_id > 0){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = "/codecamp/course";
        $extra = 'contestlist.php?course='.$course_id;
        header("Location: http://$host$uri/$extra");
        die();
      }else{
        $allView = true;
      }
    }
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

    <title>Add Contest</title>

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
          <!-- contest info start-->
          <?php require 'component\courseinfo.php'; ?>  
          <!-- contest info end-->

          <!--Buttons start-->
          <?php require 'component\menulist.php'; ?>
          <!--Buttons end-->

          <div class="row mt">
              <div class="col-lg-12">
                  <div class="form-panel">
                      <h4 class="mb">Contest Information</h4>
                      <form class="form-horizontal style-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?course=".$course_id); ?>">
                          <div class="form-group <?php if($contest_titleErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Contest Title</label>
                              <div class="col-sm-10">
                                  <input type="text" name="contesttitle" class="form-control" placeholder="Contest Title" value="<?php echo $contest_title; ?>">
                              </div>
                          </div>

                          <div class="form-group <?php if($contest_dateErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Date</label>
                              <div class="col-sm-3">
                                  <input type="date" name="contestdate" class="form-control" value="<?php echo $contest_date; ?>">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Number of Problems</label>
                              <div class="col-sm-1">
                                  <select name="noofproblem" class="form-control">
                                    <?php $i = 1;
                                      while ($i<=26) {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                        $i++;
                                      }
                                   ?>
                                </select>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                              <input type="submit" class="btn btn-theme" value="Add Contest"></input>
                            </div>
                          </div>

                      </form>
                  </div>
              </div><!-- col-lg-12-->       
            </div><!-- /row -->


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