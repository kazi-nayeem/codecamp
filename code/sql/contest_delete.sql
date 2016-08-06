SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 10;

DELETE FROM `solve_list` WHERE `solve_list`.`problem_id` IN( SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 7);

DELETE FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 7
DELETE FROM `approve_table` WHERE `approve_table`.`contest_id` = 7
DELETE FROM `contest_list` WHERE `contest_list`.`contest_id` = 7

SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = 8