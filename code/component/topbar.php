<?php 
$host = $_SERVER["HTTP_HOST"];

$dashboardLink = "http://$host/codecamp/dashboard.php";
$logoutLink = "http://$host/codecamp/component/logout.php";
$contest_link = "http://$host/codecamp/course/contest.php?id=";

$dbn = getDBH();
$stmt = $dbn->prepare('SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`approve` = 0 AND `approve_table`.`contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN
(SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = ?))');


$stmt->bind_param('i', $db_user_id);
$db_user_id = $_SESSION["userid"];
$stmt->execute();
$stmt->bind_result($totalNumberOfPending);
$stmt->fetch();
$stmt->close();
$dbn->close();

?>

<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
<section id="container">
	<!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Menu"></div>
              </div>
            <!--logo start-->
            <a href="<?php echo $dashboardLink; ?>" class="logo"><b>CODE CAMP</b></a>
            <!--logo end-->
                        <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme"><?php echo $totalNumberOfPending; ?></span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have <?php echo $totalNumberOfPending; ?> pending requests</p>
                            </li>

                            <?php 
                              $dbn = getDBH();
                              $stmt = $dbn->prepare('SELECT `approve_table`.`contest_id`, `contest_list`.`contest_name`, COUNT(*) AS pendingreq FROM `approve_table` JOIN `contest_list` ON `contest_list`.`contest_id` = `approve_table`.`contest_id` WHERE`approve_table`.`approve` = 0 AND `approve_table`.`contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN( SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = ? )) GROUP BY `approve_table`.`contest_id`');

                              $stmt->bind_param('i', $db_user_id);
                              $db_user_id = $_SESSION["userid"];
                              $stmt->execute();
                              $result = $stmt->get_result();
                              while ($row = $result->fetch_assoc()) {
                                
                            ?>
                            <li>
                                <a href="<?php echo $contest_link.$row['contest_id']; ?>">
                                    <div class="task-info">
                                        <div class="desc"> <?php echo $row['pendingreq']; ?> pending request in <?php echo $row['contest_name']; ?></div>
                                    </div>
                                    
                                </a>
                            </li>

                            <?php } ?>
                            
                        </ul>
                    </li>
                    <!-- settings end -->
                    
                </ul>
                <!--  notification end -->
            </div>
            
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="<?php echo $logoutLink; ?>">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
</section>
</body>
</html>