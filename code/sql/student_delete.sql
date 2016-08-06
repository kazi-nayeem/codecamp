DELETE FROM `approve_table` WHERE `student_id` = 7 AND `contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = 100);

DELETE FROM `solve_list` 
WHERE `student_id` = 100 AND `problem_id` 
IN
(SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` 
WHERE `contest_problem_list`.`contest_id`IN 
 (SELECT `contest_list`.`contest_id` FROM `contest_list` 
 WHERE `contest_list`.`course_id` = 100
 )
)