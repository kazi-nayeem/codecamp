SELECT `contest_problem_list`.`contest_id`, `solve_list`.`problem_id`,`solve_list`.`solve_flag` ,`solve_list`.`no_submission`, `solve_list`.`time` 
FROM `solve_list` JOIN `contest_problem_list` 
ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE `solve_list`.`student_id` = 5

SELECT `contest_problem_list`.`contest_id`, COUNT(`solve_list`.`problem_id`) AS noofproblem, COUNT(`solve_list`.`solve_flag`) AS solved, SUM(`solve_list`.`solve_flag`) ,`solve_list`.`no_submission`, `solve_list`.`time` 
FROM `solve_list` JOIN `contest_problem_list` 
ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE `solve_list`.`student_id` = 5
GROUP BY `contest_problem_list`.`contest_id`

//contest wise penalty and nomber of solve for one student
SELECT `contest_problem_list`.`contest_id`, 
COUNT(`solve_list`.`problem_id`) AS noofproblem, 
SUM(`solve_list`.`solve_flag`) AS solved, 
SUM((`solve_list`.`solve_flag`*`solve_list`.`no_submission`*1200)+`solve_list`.`time`) AS penalty
FROM `solve_list` JOIN `contest_problem_list` 
ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE `solve_list`.`student_id` = 5
GROUP BY `contest_problem_list`.`contest_id`

SELECT `contest_list`.`contest_id`, `contest_list`.`contest_name`,`contest_list`.`contest_date`,
sp.noofproblem, sp.solved,sp.point, sp.penalty
FROM `contest_list` LEFT JOIN
(SELECT `contest_problem_list`.`contest_id`, 
COUNT(`contest_problem_list`.`problem_id`) AS noofproblem, 
SUM(`solve_list`.`solve_flag`) AS solved,
SUM(`solve_list`.`solve_flag`*`contest_problem_list`.`difficulty`) as point,
SUM((`solve_list`.`solve_flag`*`solve_list`.`no_submission`*1200)+`solve_list`.`time`) AS penalty
FROM `solve_list` RIGHT JOIN `contest_problem_list` 
ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE `solve_list`.`student_id` = 5
GROUP BY `contest_problem_list`.`contest_id`) sp 
ON sp.contest_id = `contest_list`.`contest_id`
WHERE `contest_list`.`course_id` = 8



//query to find one contest submisionn of one user
SELECT `contest_problem_list`.`problem_id`, `solve_list`.`no_submission`, `solve_list`.`time` 
FROM `contest_problem_list` LEFT JOIN `solve_list`
ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE `solve_list`.`student_id` = 5 AND `contest_problem_list`.`contest_id` = 8
ORDER BY `contest_problem_list`.`problem_number`

