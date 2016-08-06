INSERT INTO `uva_problem_category` (`problem_number`, `category`) VALUES ('100', 'Easy');
INSERT INTO `uva_problem_category` (`problem_number`, `category`) VALUES (?, ?);

INSERT INTO `uva_solve` (`problem_number`, `judge_code_id`, `uva_judge_id`, `timestamp`) VALUES (?, ?, ?, ?);

DELETE FROM `uva_solve` WHERE `uva_solve`.`timestamp`>=0;
DELETE FROM `uva_solve` WHERE `uva_solve`.`timestamp`>=?;


SELECT MAX(`uva_solve`.`uva_judge_id`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = 8;
SELECT MAX(`uva_solve`.`uva_judge_id`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = ?;

SELECT COUNT(`uva_solve`.`problem_number`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = 8 AND `uva_solve`.`timestamp`>=0
SELECT COUNT(`uva_solve`.`problem_number`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = ? AND `uva_solve`.`timestamp`>=?

SELECT COUNT(`uva_solve`.`problem_number`) as `numberofsolve`, `uva_problem_category`.`category` 
FROM `uva_solve` join `uva_problem_category`
ON `uva_solve`.`problem_number` = `uva_problem_category`.`problem_number`
WHERE `uva_solve`.`judge_code_id` = 7
GROUP BY `uva_problem_category`.`category`;  