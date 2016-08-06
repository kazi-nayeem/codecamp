<?php 
updateUserUvaSolve($viewContentFor);
updateCodeforcesUserID($viewContentFor);
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	              <div class="row">
                  <div class="col-lg-12 main-chart">
                  	
                                       
                      <div class="row mt">
                      <!-- ONLINE JUDGE STATUS PANELS START-->
                      <div class="form-panel col-lg-11 main-chart">	
                      	<h3>OVERVIEW</h3>
                        <!--uva overview start-->                     	
							           <div class="col-md-6 mb">
								          <!-- WHITE PANEL - TOP USER -->
								          <div class="white-panel pn">
									         <div class="white-header">
										      <h5>UVA STATUS</h5>
									</div>
									<p><b><?php
                    $uva = getUVAHandle($viewContentFor);
                    if(is_null($uva)) $uva = "Not Available";
                    echo $uva; 

                   ?></b></p>
									<p><b>ACCEPTED</b></p>
									<div class="row">
										<div class="col-md-6">
											<p class="small mt">TOTAL</p>
											<p><?php echo getUvaNumberOfSolve($viewContentFor); ?></p>
										</div>
										<div class="col-md-6">
											<p class="small mt">LAST 7 DAYS</p>
											<p><?php echo getUvaNumberOfSolve($viewContentFor,time()-(7*24*60*60)); ?></p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<p class="small mt">LAST 1 MONTH</p>
											<p><?php echo getUvaNumberOfSolve($viewContentFor,time()-(30*24*60*60)); ?></p>
										</div>
										<div class="col-md-6">
											<p class="small mt">LAST 1 YEAR</p>
											<p><?php echo getUvaNumberOfSolve($viewContentFor,time()-(365*24*60*60)); ?></p>
										</div>
									</div>
								</div>
							</div><!-- /col-md-4 -->
              <!--uva overview end-->

              <!--codeforces overview start-->
              <div class="col-md-6 mb">
                          <!-- WHITE PANEL - TOP USER -->
                          <div class="white-panel pn">
                           <div class="white-header">
                          <h5>CODEFORCES STATUS</h5>
                  </div>
                  <p><b><?php 
                    $codefor = getCodeforcesHandle($viewContentFor);
                    if(is_null($codefor)) $codefor = "Not Available"; 
                  echo $codefor; ?></b></p>
                  <p><b>ACCEPTED</b></p>
                  <div class="row">
                    <div class="col-md-6">
                      <p class="small mt">TOTAL</p>
                      <p><?php echo getCodeforcesNumberOfSolve($viewContentFor); ?></p>
                    </div>
                    <div class="col-md-6">
                      <p class="small mt">LAST 7 DAYS</p>
                      <p><?php echo getCodeforcesNumberOfSolve($viewContentFor,time()-(7*24*60*60)); ?></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <p class="small mt">LAST 1 MONTH</p>
                      <p><?php echo getCodeforcesNumberOfSolve($viewContentFor,time()-(30*24*60*60)); ?></p>
                    </div>
                    <div class="col-md-6">
                      <p class="small mt">LAST 1 YEAR</p>
                      <p><?php echo getCodeforcesNumberOfSolve($viewContentFor,time()-(365*24*60*60)); ?></p>
                    </div>
                  </div>
                </div>
              </div><!-- /col-md-4 -->
              <!--codeforces overview end-->        	
						</div>
						<!-- ONLINE JUDGE STATUS PANELS END-->

        </div><!-- /row -->
                    
					
						
					
      </div><!-- /col-lg-9 END SECTION MIDDLE -->
                                  
               
                  
    </div><!--/row -->
   
    <div class="row">
         <!--Uva topic wise list start-->
        <div class="col-md-12">
                <div class="content-panel">
                    <h4> Uva Solve Problem By Category</h4>
                           <hr>
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                  <th>Topic Name</th>
                                  <th>Number Of Solved</th>
                                  <th>Topic Name</th>
                                  <th>Number Of Solved</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
                                $dbn = getDBH();

                                $stmt = $dbn->prepare('SELECT COUNT(`uva_solve`.`problem_number`) as `numberofsolve`, `uva_problem_category`.`category` FROM `uva_solve` join `uva_problem_category` ON `uva_solve`.`problem_number` = `uva_problem_category`.`problem_number` WHERE `uva_solve`.`judge_code_id` = ? GROUP BY `uva_problem_category`.`category`;');

                                $stmt->bind_param('i', $judge_code_id);
                                $judge_code_id = getUVaJudgeCodeID(getUVAHandle($viewContentFor));
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ( $row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                  <td><?php echo $row["category"]; ?></td>
                                  <td><?php echo $row["numberofsolve"]; ?></td>
                                  <?php 
                                      if($row = $result->fetch_assoc()){
                                  ?>
                                      <td><?php echo $row["category"]; ?></td>
                                      <td><?php echo $row["numberofsolve"]; ?></td>
                                  <?php
                                      }

                                   ?>
                              </tr>
                           <?php
                              }
                              $result->free();
                              $stmt->close();
                              $dbn->close();
                            ?>
                              
                              
                              </tbody>
                          </table>
                        </div><!--/content-panel -->
                    </div><!-- /col-md-12 -->
                    <!--Uva topic wise list end-->

                    <!--Codeforces topic wise list start-->
                    <div class="col-md-12 mt">
                      <div class="content-panel">
                            <table class="table table-hover">
                            <h4>Codeforces Solved Problem By Category</h4>
                            <hr>
                                <thead>
                                <tr>
                                  <th>Topic Name</th>
                                  <th>Number Of Solved</th>
                                  <th>Topic Name</th>
                                  <th>Number Of Solved</th>
                              </tr>
                                </thead>
                                <tbody>
                              <?php 
                                $dbn = getDBH();

                                $stmt = $dbn->prepare('SELECT COUNT(`codeforces_solve`.`problem_number`) as `numberofsolve`, `codeforces_category`.`category` FROM `codeforces_solve` join `codeforces_category` ON `codeforces_solve`.`problem_number` = `codeforces_category`.`problem_number` WHERE `codeforces_solve`.`judge_code_id` = ? GROUP BY `codeforces_category`.`category`;');

                                $stmt->bind_param('i', $judge_code_id);
                                $judge_code_id = getCodeforcesJudgeCodeID(getCodeforcesHandle($viewContentFor));
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ( $row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                  <td><?php echo $row["category"]; ?></td>
                                  <td><?php echo $row["numberofsolve"]; ?></td>
                                  <?php 
                                      if($row = $result->fetch_assoc()){
                                  ?>
                                      <td><?php echo $row["category"]; ?></td>
                                      <td><?php echo $row["numberofsolve"]; ?></td>
                                  <?php
                                      }

                                   ?>
                              </tr>
                           <?php
                              }
                              $result->free();
                              $stmt->close();
                              $dbn->close();
                            ?>
                              
                              
                              </tbody>
                            </table>
                        </div><!--/content-panel -->
                    </div><!-- /col-md-12 -->
                     <!--Codeforces topic wise list end-->
        </div><!-- row -->
</body>
</html>