INSERT INTO `course_table` (`owner_id`, `course_title`, `course_password`, `start_date`) VALUES ('6', 'CSE 100', '', CURRENT_TIMESTAMP);
INSERT INTO `course_table` (`owner_id`, `course_title`, `course_password`, `start_date`) VALUES (?, ?, ?, CURRENT_TIMESTAMP);

SELECT `course_table`.`course_id`, `course_table`.`course_title` FROM `course_table` WHERE owner_id = 6
SELECT `course_table`.`course_id`, `course_table`.`course_title` FROM `course_table` WHERE owner_id = ?;

SELECT `course_table`.`owner_id` FROM `course_table` WHERE course_id = 3 AND course_password = '1';
SELECT `course_table`.`owner_id` FROM `course_table` WHERE course_id = ? AND course_password = ?;

INSERT INTO `enroll_table` (`course_id`, `student_id`, `enroll_id`, `enroll_date`) VALUES ('1', '6', '27', CURRENT_TIMESTAMP);
INSERT INTO `enroll_table` (`course_id`, `student_id`, `enroll_id`, `enroll_date`) VALUES (?, ?, ?, CURRENT_TIMESTAMP);

SELECT `course_table`.`course_id`, `course_table`.`course_title` 
FROM `course_table` JOIN 'enroll_table' 
ON `course_table`.`course_id` = `enroll_table`.`course_id` 
WHERE `enroll_table`.`student_id` = 6;

SELECT `course_table`.`course_id`, `course_table`.`course_title` FROM `course_table` JOIN 'enroll_table' ON `course_table`.`course_id` = `enroll_table`.`course_id` WHERE `enroll_table`.`student_id` = ?;

SELECT `course_table`.`owner_id` FROM `course_table` WHERE `course_table`.`course_id` = ?;

SELECT `course_table`.`course_title` FROM `course_table` WHERE `course_table`.`course_id` = ?;

SELECT COUNT(`enroll_table`.`student_id`) FROM `enroll_table` WHERE `enroll_table`.`course_id` = 3;
SELECT COUNT(`enroll_table`.`student_id`) FROM `enroll_table` WHERE `enroll_table`.`course_id` = ?;

SELECT `user_table`.`user_name`,`enroll_table`.`enroll_id`, `enroll_table`.`enroll_date` 
FROM `enroll_table` JOIN `user_table` ON `user_table`.`user_id` = `enroll_table`.`student_id` 
WHERE `enroll_table`.`course_id` = 3;

SELECT `user_table`.`user_id`, `user_table`.`user_name`,`enroll_table`.`enroll_id`, `enroll_table`.`enroll_date` 
FROM `enroll_table` JOIN `user_table` ON `user_table`.`user_id` = `enroll_table`.`student_id` 
WHERE `enroll_table`.`course_id` = ?;

UPDATE `course_table` SET `course_title` = 'CSE 1001', `course_password` = '11' WHERE `course_table`.`course_id` = 9;
UPDATE `course_table` SET `course_title` = ?, `course_password` = ? WHERE `course_table`.`course_id` = ?;

SELECT `enroll_table`.`enroll_id` FROM `enroll_table` WHERE `enroll_table`.`course_id` = 4 AND `enroll_table`.`student_id` = 5;
SELECT `enroll_table`.`enroll_id` FROM `enroll_table` WHERE `enroll_table`.`course_id` = ? AND `enroll_table`.`student_id` = ?;

DELETE FROM `enroll_table` WHERE `enroll_table`.`course_id` = 3 AND `enroll_table`.`student_id` = 6;
DELETE FROM `enroll_table` WHERE `enroll_table`.`course_id` = ? AND `enroll_table`.`student_id` = ?;