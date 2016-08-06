<?php 
require 'component\security.php';
require_once 'db\connect.php';
require_once 'db\database.php';
require_once 'judge\uva.php';
require_once 'judge\codeforces.php';
require_once 'judge\vjudge.php';

//get user general info
require_once 'profileinfo\userinfo.php';

//get user judge handle info

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Profile</title>

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
              <div class="row mt">
              <div class="col-lg-12">
                  <div class="form-panel">
                      <h3 class="mb">Information</h3>
                      <form class="form-horizontal style-form">

                          <!--user name start-->                     
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo $userName; ?></label>
                              </div>
                          </div>                          
                          <!--user name end-->


                          <!-- user uva start-->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Uva Handle</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo getUVAHandle($user_id) ?></label>
                              </div>
                          </div>
                          <!-- user uva end-->


                          <!-- user codeforces start-->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Codeforces Handle</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo getCodeForcesHandle($user_id) ?></label>
                              </div>
                          </div>
                          <!-- user codeforces end-->


                          <!-- user vjudge start-->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Vjudge Handle</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo getVjudgeHandle($user_id) ?></label>
                              </div>
                          </div>
                          <!-- user vjudge end-->

                          <!-- user email start-->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Email</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo $userEmail; ?></label>
                              </div>
                          </div>
                          <!-- user email end-->


                          <!-- user reg date start-->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Registration Date</label>
                              <div class="col-sm-10">
                                  <label class="col-sm-2 col-sm-2 control-label"><?php echo $userRegDate; ?></label>
                              </div>
                          </div>
                          <!-- user reg date end-->
                      </form>
                      <button type="button" class="btn btn-theme btn-round"><a href="update.php" style="color: white">Update</a></button>
                      
                  </div>
              </div><!-- col-lg-12-->       
            </div><!-- /row -->
        </section>
    </section>

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