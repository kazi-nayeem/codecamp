<?php 
require_once '..\component\security.php';
require_once '..\db\database.php';
require_once '..\profileinfo\userinfo.php';
require_once '..\function\formvalidation.php';
require_once 'operation\contest.php';

if(isset($_GET['id'])){
    $contest_id = $_GET['id'];
}else{
  require 'operation\movetodashboard.php';
}

if($_SESSION['userid'] != getContestOwnerID($contest_id)){
  require 'operation\movetodashboard.php';
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $i = 0;
  $dbn = getDBH();
  $stmt = $dbn->prepare('UPDATE `contest_problem_list` SET `difficulty` = ? WHERE `contest_problem_list`.`problem_id` = ?;');
  $stmt->bind_param('ii', $db_point, $db_problem_id);

  foreach ($_POST['problemid'] as  $problem_id) {
    $db_point = $_POST['point'][$i];
    $db_problem_id = $problem_id;
    $stmt->execute();
    $i++;
  }

  $stmt->close();
  $dbn->close();

  $host  = $_SERVER['HTTP_HOST'];
  $uri   = '/codecamp/course';
  $extra = 'contestlist.php?course='.getContestCourseID($contest_id);
  header("Location: http://$host$uri/$extra");
  die();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

    <title>Update Contest</title>

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
            <div class="col-lg-10 main-chart">
                    
                                       
              <div class="row mt">
                    <!-- ONLINE JUDGE STATUS PANELS START-->
                <div class="form-panel col-lg-12 main-chart"> 
                  <h3>Update Contest</h3>                       
                  <h4>Contest Name: <?php echo getContestNameAndDate($contest_id); ?></h4>
                    <!-- WHITE PANEL - TOP USER -->
                    <form class="form-horizontal style-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$contest_id);?>">
                        <hr>
                        <?php 
                            $dbn = getDBH();
                            $stmt = $dbn->prepare('SELECT `problem_id`, `problem_number`, `difficulty` FROM `contest_problem_list` WHERE `contest_id` = ? ORDER BY `problem_number`  ASC');
                            $stmt->bind_param('i', $db_contest_id);
                            $db_contest_id = $contest_id;
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                            
                         ?>
                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Problem No.</label>
                          <div class="col-sm-10">
                            <label class="col-sm-2 col-sm-2 control-label"><?php echo $row["problem_number"]; ?></label>
                            <input type="hidden" name="problemid[]" value="<?php echo $row['problem_id']; ?>">
                            <label class="col-sm-1 col-sm-1 control-label">Point:</label>
                            <div class="col-sm-2">
                              <select name="point[]" class="form-control">
                                  <?php 
                                    $j = 0;
                                    while ($j<10) {
                                      $j++;
                                  ?>
                                    <option value="<?php echo $j; ?>"  <?php if($j == $row['difficulty']) {?> selected="selected" <?php } ?> > <?php  echo $j;?> </option>
                                  <?php 
                                    }
                                   ?>
                            </select>
                            </div>

                          </div>
                        </div>
                        <?php 
                          }
                            $result->free();
                            $stmt->close();
                            $dbn->close();
                         ?>
                        

                          <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                              <input type="submit" class="btn btn-theme" value="Update">
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