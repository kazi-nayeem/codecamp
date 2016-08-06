<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<div class="row mt">
      <div class="col-md-12">
        
           
           <div class="showback">
           <div class="btn-group btn-group-justified">
              <div class="btn-group">
                <a href="dashboard.php?course=<?php echo $course_id;?>"><button type="button" class="btn btn-theme">Course Dashboard</button> </a>
              </div>
              <div class="btn-group">
                <a href="dashboard.php?course=<?php echo $course_id; ?>"><button type="button" class="btn btn-theme">Student List</button> </a>
              </div>
              <div class="btn-group">
                <a href="contestlist.php?course=<?php echo $course_id; ?>"><button type="button" class="btn btn-theme">Contest List</button> </a>
              </div>
              <div class="btn-group">
                <a href="addcontest.php?course=<?php echo $course_id; ?>"><button type="button" class="btn btn-theme">Add Contest</button> </a>
              </div>
              
              <div class="btn-group">
                <a href="update.php?course=<?php echo $course_id; ?>"><button type="button" class="btn btn-theme">Update Course</button> </a>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-danger"><a href="operation/delete.php?course=<?php echo $course_id; ?>" style="color: white">Delete Course</a></button>
              </div>
          </div>
          </div>
                        
        <!-- /content-panel -->
      </div><!-- /col-md-12 -->
    </div><!-- /row -->
</body>
</html>