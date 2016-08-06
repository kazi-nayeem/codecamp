<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<div class="row mt">
  <div class="col-md-12">
      <div class="content-panel">
          <table class="table table-striped table-advance table-hover sortable" id="ranktable">
              <h4>All Contest Merge Ranklist</h4>
            
              <thead>
              <tr>
                  <th id="sri">#</th>
                  <th id="name">Student Name</th>
                  <th id="reg">Reg No.</th>
                  <th id="solve"> Solved</th>
                  <th id="poi">Points</th>
                  <th id="penalty">Penalty</th>
              </tr>
              </thead>
              <tbody>
              <?php 
                $dbn = getDBH();
								$stmt = $dbn->prepare('SELECT `user_table`.`user_name`,`enroll_table`.`enroll_id`,`solve_list`.`student_id`, SUM( `contest_problem_list`.`difficulty` * `solve_list`.`solve_flag` ) AS points, SUM((`solve_list`.`no_submission` * `solve_list`.`solve_flag` * 1200 ) + `solve_list`.`time`) AS penalty, SUM(`solve_list`.`solve_flag`) AS sloved FROM `contest_problem_list` JOIN `solve_list` ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id` JOIN `enroll_table` ON `enroll_table`.`student_id` = `solve_list`.`student_id` AND `enroll_table`.`course_id` = ? JOIN `user_table` ON `user_table`.`user_id` = `solve_list`.`student_id` WHERE `contest_problem_list`.`contest_id` IN( SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?) GROUP BY `solve_list`.`student_id` ORDER BY points DESC, penalty ASC');
								$stmt->bind_param('ii', $db_course_id1, $db_course_id2);
                $db_course_id1 = $course_id;
								$db_course_id2 = $course_id;
								$stmt->execute();
								$result = $stmt->get_result();
								if($result->num_rows == 0){
								?>
								<tr><td colspan="6" style="text-align: center; font-size: 150%">No Contest Found</td></tr>
								<?php
								}
                $rank = 1;
								while ( $row = $result->fetch_assoc()) {
                ?>

                 <tr>
                    <td><?php echo $rank++; ?></td>
                    <td><a href="student.php?course=<?php echo $course_id."&student=".$row["student_id"]; ?>"><?php echo $row["user_name"]; ?></a></td>
                    <td><?php echo $row['enroll_id']; ?></td>
                    <td><?php echo $row['sloved']; ?></td>
                    <td><?php echo $row['points']; ?></td>
                    <td><?php echo subView($row['penalty']); ?></td>
                  </tr>
              	<?php 
                }
								$result->free();
								$stmt->close();
								$dbn->close();
                ?>

                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->
</body>
</html>