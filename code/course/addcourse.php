<?php 
require '..\component\security.php';
require '..\db\database.php';
require '..\profileinfo\userinfo.php';
require '..\function\formvalidation.php';
$course_title = $course_pass = "";
$allview = $course_titleErr = $course_passErr = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty($_POST["coursetitle"])){
    $course_titleErr = true;
  }else{
    $course_title = formatInput($_POST["coursetitle"]);

  }
  if(empty($_POST["coursepass"])){
    $course_passErr = true;
  }else{
    $course_pass = formatInput($_POST["coursepass"]);
  }

  $allview = ($course_titleErr or $course_passErr);

  if(!$allview){

    $db = getDBH();
    $stmt = $db->prepare('INSERT INTO `course_table` (`owner_id`, `course_title`, `course_password`, `start_date`) VALUES (?, ?, ?, CURRENT_TIMESTAMP);');
    $stmt->bind_param("iss", $owner_id, $title, $pass);
    $owner_id = $_SESSION["userid"];
    $title = $course_title;
    $pass = $course_pass;
    
    if($stmt->execute() == true){
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = "/codecamp/course";
      $extra = 'dashboard.php?course='.$stmt->insert_id;
      header("Location: http://$host$uri/$extra");
      $db->close();
      die();
    }
    $db->close();
  }
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

    <title>Add Course</title>

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

          <div class="row">
            <div class="col-lg-11 main-chart">
                  	
                                       
              <div class="row mt">
                    <!-- ONLINE JUDGE STATUS PANELS START-->
                <div class="form-panel col-lg-12 main-chart">	
                  <h3>Add Course</h3>                     	
							   
								    <!-- WHITE PANEL - TOP USER -->
								    <form class="form-horizontal style-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                          <!--user name input start-->                     
                          <div class="form-group <?php if($course_titleErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Course Title</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="coursetitle" class="form-control" placeholder="Course Title" <?php if($allview) echo 'value="',$course_title,'"';?>>
                              </div>
                          </div>                          
                          <!--user name input end-->

                          <!--user email input start-->                     
                          <div class="form-group <?php if($course_passErr == true) {echo "has-error";}?>">
                              <label class="col-sm-2 col-sm-2 control-label">Course Registration Code</label>
                              <div class="col-sm-10">
                                  <input type="text"  name="coursepass" class="form-control" placeholder="Course Registration Code" <?php if($allview) echo 'value="',$course_pass,'"';?>>
                              </div>
                          </div>                          
                          <!--user email input end-->


                          <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                              <input type="submit" class="btn btn-theme" value="Register"></input>
                            </div>
                          </div>
                          
                      </form>
							<!-- /col-md-4 -->
                      	
						</div>
						<!-- ONLINE JUDGE STATUS PANELS END-->

            </div><!-- /row -->
                    
					
					
					
         </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
               
                  
            </div><!--/row -->
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