DELETE FROM `contest_problem_list` WHERE `contest_id` IN
(SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = 100)

DELETE FROM `contest_list` WHERE `course_id` = 11