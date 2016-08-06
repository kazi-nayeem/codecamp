SELECT `approve_table`.`contest_id`, `approve_table`.`approve` FROM `approve_table` WHERE `approve_table`.`contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN
(SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = 5))

SELECT `approve_table`.`contest_id`, `approve_table`.`approve` FROM `approve_table` WHERE `approve_table`.`approve` = 0 AND `approve_table`.`contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN
(SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = 5))

SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`approve` = 0 AND `approve_table`.`contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN
(SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = 5))

SELECT `approve_table`.`contest_id`, `contest_list`.`contest_name`, COUNT(*) AS pendingreq FROM `approve_table` JOIN `contest_list` ON `contest_list`.`contest_id` = `approve_table`.`contest_id` WHERE`approve_table`.`approve` = 0 AND `approve_table`.`contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` IN( SELECT `course_table`.`course_id` FROM `course_table` WHERE `course_table`.`owner_id` = 5 )) GROUP BY `approve_table`.`contest_id`