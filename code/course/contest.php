<?php 
require_once '..\component\security.php';
require_once '..\db\database.php';
require_once '..\profileinfo\userinfo.php';
require_once '..\judge\vjudge.php';
require_once 'operation\contest.php';

if(!isset($_GET["id"])){
  require 'operation\movetodashboard.php';
}

$contest_id = $_GET["id"];

if($_SESSION['userid'] != getContestOwnerID($contest_id)){
    require 'operation\movetodashboard.php'; 
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

    <title>Contest Ranklist</title>

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


        <?php $course_id = getContestCourseID($contest_id); 
        require 'component\shortmenulist.php'; ?>

          <div class="col-md-12 mt">
              <div class="content-panel">
                        <table class="table table-hover" border="1">
                            <h4><?php echo getContestNameAndDate($contest_id)." Ranklist"; ?></h4>
                            <button class="btn btn-info btn-xs pull-right"><a style="color: white" href="operation/contestranklistapproveall.php?id=<?php echo $contest_id; ?>">Accept All</a></button>
                            
                              <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Reg No.</th>
                                    <th>vJudge Username</th>
                                    <th>Solved</th>
                                    <th>Point</th>
                                    <th>Penalty</th>
                                    <?php 
                                      $i = "A";
                                      $noofproblem = numberOfProblemInOneContest($contest_id);
                                      while ($noofproblem>0) {
                                    ?>
                                    <th><?php echo $i; ?></th>
                                    <?php 
                                    $noofproblem--;
                                    $i++;
                                    }
                                   ?>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                  $dbn = getDBH();
                                  $stmt = $dbn->prepare('SELECT ranklist.student_id , `user_table`.`user_name`, solved,tpoint,penalty
                                              FROM `user_table` JOIN
                                              (SELECT `solve_list`.`student_id`,
                                              SUM(`solve_list`.`solve_flag`) AS solved, 
                                              SUM(`solve_list`.`time`+(1200*`solve_list`.`solve_flag`*`solve_list`.`no_submission`)) AS penalty,
                                              SUM(`contest_problem_list`.`difficulty`*`solve_list`.`solve_flag`) as tpoint
                                              FROM `solve_list` JOIN `contest_problem_list` 
                                              ON `solve_list`.`problem_id` = `contest_problem_list`.`problem_id`
                                              WHERE `contest_problem_list`.`contest_id` = ?
                                              GROUP BY `solve_list`.`student_id`
                                              ORDER BY tpoint DESC, penalty ASC) ranklist
                                              ON ranklist.student_id = `user_table`.`user_id`');

                                  $stmt->bind_param('i', $db_contest_id);
                                  $db_contest_id = $contest_id;
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  $rank = 1;
                                  while ($row = $result->fetch_assoc()) {
                                    

                                ?>
                                <tr>
                                    <td><?php echo $rank; ?></td>
                                    <td><a href="student.php?course=<?php echo $course_id."&student=".$row["student_id"]; ?>"><?php echo $row["user_name"]; ?></a></td>
                                    <td><?php echo getEnrollIDofStudent($contest_id,$row['student_id']); ?></td>
                                    <td><?php echo getVjudgeHandle($row['student_id']); ?></td>
                                    <td><?php echo $row['solved']; ?></td>
                                    <td><?php echo $row['tpoint']; ?></td>
                                    <td><?php echo $row['penalty']; ?></td>
                                    <?php viewStudentSubmission($contest_id,$row['student_id'],0) ?>
                                    <td>
                                    <?php if(isPendingRequest($contest_id,$row['student_id'])){ ?>
                                      <button class="btn btn-info btn-xs"><a style="color: white" href="operation/contestranklistapprove.php?id=<?php echo $contest_id."&student=".$row['student_id']; ?>">Accept</a></button>
                                    <?php } ?>

                                      <button class="btn btn-danger btn-xs"><a style="color: white" href="operation/contestranklistreject.php?id=<?php echo $contest_id."&student=".$row['student_id']; ?>">Reject</a></button>

                                    </td>
                                </tr>
                                <?php
                                  $rank++; 
                                  }
                                  $result->free();
                                  $stmt->close();
                                  $dbn->close();
                                 ?>
                              </tbody>
                            </table>
                        </div><!--/content-panel -->
                    </div><!-- /col-md-12 -->

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