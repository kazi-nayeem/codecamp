INSERT INTO `contest_list` (`contest_id`, `course_id`, `contest_name`, `contest_date`) VALUES (NULL, '8', 'test', '2016-03-02 00:00:00');
INSERT INTO `contest_list` (`contest_id`, `course_id`, `contest_name`, `contest_date`) VALUES (NULL, '8', 'test', '2016-02-31 00:00:00');

INSERT INTO `contest_list` (`contest_id`, `course_id`, `contest_name`, `contest_date`) VALUES (NULL, '8', 'sdgsdf', '2016-03-02');
INSERT INTO `contest_list` (`contest_id`, `course_id`, `contest_name`, `contest_date`) VALUES (NULL, ?, ?, ?);

INSERT INTO `contest_problem_list` (`problem_id`, `problem_number`, `contest_id`, `difficulty`) VALUES (NULL, 'a', '3', '1');
INSERT INTO `contest_problem_list` (`problem_id`, `problem_number`, `contest_id`, `difficulty`) VALUES (NULL, ? , ?, '1');

SELECT `contest_list`.`contest_id`, `contest_list`.`contest_name`, `contest_list`.`contest_date` 
FROM `contest_list`, (SELECT `contest_problem_list`.`contest_id`, COUNT(*)  as `count` FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`) a 
WHERE `contest_list`.`course_id` = 8, ;

SELECT `contest_problem_list`.`contest_id`, COUNT(*) FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`

(SELECT `contest_problem_list`.`contest_id`, COUNT(*) FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`) a

SELECT `contest_list`.`contest_id`, `contest_list`.`contest_name`, a.count, `contest_list`.`contest_date` 
FROM `contest_list`
JOIN (
	SELECT `contest_problem_list`.`contest_id`, COUNT(*)  as `count` 
	FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`) a 
ON a.contest_id = `contest_list`.`contest_id`
WHERE `contest_list`.`course_id` = ?;

SELECT  MAX(a.count) AS maxcount
FROM `contest_list`
JOIN (
	SELECT `contest_problem_list`.`contest_id`, COUNT(*)  as `count` 
	FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`) a 
ON a.contest_id = `contest_list`.`contest_id`
WHERE `contest_list`.`course_id` = ?;

SELECT contest_id,contest_name,contest_date FROM `contest_list` WHERE `contest_list`.`course_id` = ?;

SELECT `contest_list`.`contest_name`,`contest_list`.`contest_date` FROM `contest_list` WHERE `contest_list`.`contest_id` = 7;
SELECT `contest_list`.`contest_name`,`contest_list`.`contest_date` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?;

SELECT COUNT(*) FROM `enroll_table` WHERE `enroll_table`.`student_id` = 5 AND `enroll_table`.`course_id` LIKE
(SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = 7);
SELECT COUNT(*) FROM `enroll_table` WHERE `enroll_table`.`student_id` = ? AND `enroll_table`.`course_id` LIKE
(SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?);

SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = 7 AND `contest_problem_list`.`problem_id` 
NOT IN (SELECT `solve_list`.`problem_id` FROM `solve_list` WHERE `solve_list`.`student_id` = 5) ORDER BY `contest_problem_list`.`problem_id`;
SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ? AND `contest_problem_list`.`problem_id` 
NOT IN (SELECT `solve_list`.`problem_id` FROM `solve_list` WHERE `solve_list`.`student_id` = ?) ORDER BY `contest_problem_list`.`problem_id`;

INSERT INTO `approve_table` (`contest_id`, `student_id`, `approve`) VALUES ('7', '5', '0');
INSERT INTO `approve_table` (`contest_id`, `student_id`, `approve`) VALUES (?, ?, "0");


SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`student_id` = 5 AND `approve_table`.`contest_id` = 100;
SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`student_id` = ? AND `approve_table`.`contest_id` = ?;

SELECT `course_table`.`owner_id` 
FROM `contest_list` JOIN `course_table` 
ON `contest_list`.`course_id` = `course_table`.`course_id` 
WHERE `contest_list`.`contest_id` = 10;











