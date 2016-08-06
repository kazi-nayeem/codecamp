<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
              <p class="small mt">Registration Code</p>
              <p><?php echo getRegistrationCode($course_id); ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <p class="small mt">Total Student</p>
              <p><?php echo getTotalStudent($course_id); ?></p>
            </div>
            <div class="col-md-6">
              <p class="small mt">Start Date</p>
              <p><?php echo getCourseStartDate($course_id); ?></p>
            </div>
          </div>
          
        </div>
        <!-- course info start-->
      </div><!-- col-lg-12-->       
    </div><!-- /row -->              
          
</body>
</html>