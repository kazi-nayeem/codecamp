<?php 
$host = $_SERVER["HTTP_HOST"];
$dashboardLink = "http://$host/codecamp/dashboard.php";
$profileLink = "http://$host/codecamp/profile.php";
$addNewCourseLink = "http://$host/codecamp/course/addcourse.php";
$registerNewCourseLink = "http://$host/codecamp/course/registercourse.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="<?php echo $profileLink; ?>"><img src="<?php $_SERVER['HTTP_HOST'] ?>/codecamp/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo getUserName($_SESSION["userid"]) ?></h5>
              	  	
                  <li class="mt">
                      <a href="<?php echo $dashboardLink; ?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>


                  
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-book"></i>
                          <span>Enrolled Course</span>
                      </a>
                      <ul class="sub">
                          <?php 
                            $dbn = getDBH();
                            $mycourse = $dbn->prepare('SELECT `course_table`.`course_id`, `course_table`.`course_title` 
                            FROM `course_table` JOIN `enroll_table` 
                            ON `course_table`.`course_id` = `enroll_table`.`course_id` 
                            WHERE `enroll_table`.`student_id` = ?;');

                            $mycourse->bind_param('i', $id);
                            $id = $_SESSION["userid"];
                            $mycourse->execute();
                            $result = $mycourse->get_result();
                            
                            while ($row = $result->fetch_assoc()) {
                          ?>
                              <li><a  href="<?php $_SERVER["HTTP_HOST"] ?>/codecamp/course/student.php?course=<?php echo $row["course_id"]; ?>"><?php echo $row["course_title"]; ?></a></li>
                          <?php
                            }
                            $mycourse->close();
                            $result->free_result();
                            $dbn->close();
                          ?>
                          <li><a  href="<?php echo $registerNewCourseLink; ?>">Enroll New Course</a></li>
                      </ul>
                  </li>

                  <!--offer course start -->
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-tasks"></i>
                          <span>Offered Course</span>
                      </a>
                      <ul class="sub">
                          <?php 
                          $dbn = getDBH();
                          $mycourse = $dbn->prepare('SELECT `course_table`.`course_id`, `course_table`.`course_title` FROM `course_table` WHERE owner_id = ?;');
                          $mycourse->bind_param('i', $id);
                          $id = $_SESSION["userid"];
                          $mycourse->execute();
                          $result = $mycourse->get_result();
                          while ($row = $result->fetch_assoc()) {
                          ?>
                          <li><a  href="<?php $_SERVER["HTTP_HOST"] ?>/codecamp/course/dashboard.php?course=<?php echo $row["course_id"]; ?>"><?php echo $row["course_title"]; ?></a></li>
                          <?php 
                          }
                          $mycourse->close();
                          $result->free_result();
                          $dbn->close();
                          ?>
                          <li><a  href="<?php echo $addNewCourseLink; ?>">Offer New Course</a></li>
                      </ul>
                  </li>
                  <!--offer course end -->
                  <li class="sub-menu">
                      <a href="<?php echo $profileLink; ?>" >
                          <i class="fa fa-th"></i>
                          <span>Profile</span>
                      </a>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
</body>
</html>