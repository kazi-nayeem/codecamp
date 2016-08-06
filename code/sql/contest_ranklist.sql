SELECT COUNT(*) FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 10;
SELECT COUNT(*) FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ?;

SELECT `enroll_table`.`enroll_id` FROM `enroll_table` WHERE `enroll_table`.`student_id` = 5 
AND `enroll_table`.`course_id` =
(SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = 10)

SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 10

SELECT `solve_list`.`student_id`,
SUM(`solve_list`.`solve_flag`) AS solved, 
SUM(`solve_list`.`time`+(1200*`solve_list`.`solve_flag`*`solve_list`.`no_submission`)) AS penalty,
SUM(`contest_problem_list`.`difficulty`*`solve_list`.`solve_flag`) as point
FROM `solve_list` JOIN `contest_problem_list` 
ON `solve_list`.`problem_id` = `contest_problem_list`.`problem_id`
WHERE `contest_problem_list`.`contest_id` = 10
GROUP BY `solve_list`.`student_id`

//ranklist of a contest
SELECT ranklist.student_id , `user_table`.`user_name`, solved,point,penalty
FROM `user_table` JOIN
(SELECT `solve_list`.`student_id`,
SUM(`solve_list`.`solve_flag`) AS solved, 
SUM(`solve_list`.`time`+(1200*`solve_list`.`solve_flag`*`solve_list`.`no_submission`)) AS penalty,
SUM(`contest_problem_list`.`difficulty`*`solve_list`.`solve_flag`) as point
FROM `solve_list` JOIN `contest_problem_list` 
ON `solve_list`.`problem_id` = `contest_problem_list`.`problem_id`
WHERE `contest_problem_list`.`contest_id` = 10
GROUP BY `solve_list`.`student_id`
ORDER BY point DESC, penalty ASC) ranklist
ON ranklist.student_id = `user_table`.`user_id`