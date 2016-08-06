SELECT `problem_id`, `problem_number`, `difficulty` FROM `contest_problem_list` 
WHERE `contest_id` = 10
ORDER BY `problem_number`  ASC

UPDATE `contest_problem_list` SET `difficulty` = ? WHERE `contest_problem_list`.`problem_id` = ?;