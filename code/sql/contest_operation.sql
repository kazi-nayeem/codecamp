UPDATE `approve_table` SET `approve` = '0' WHERE `approve_table`.`contest_id` = 10 AND `approve_table`.`student_id` = 6;
UPDATE `approve_table` SET `approve` = '1' WHERE `approve_table`.`contest_id` = ? AND `approve_table`.`student_id` = ?;

DELETE FROM `solve_list`
WHERE `solve_list`.`student_id` = 5 
AND `solve_list`.`problem_id` IN 
(SELECT `contest_problem_list`.`problem_id` 
 FROM `contest_problem_list` 
 WHERE `contest_problem_list`.`contest_id` = 10)

 DELETE FROM `approve_table` WHERE `approve_table`.`contest_id` = 10 AND `approve_table`.`student_id` = 5;