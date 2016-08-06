UPDATE `user_table` SET `user_name` = ? WHERE `user_table`.`user_id` = ?;

DELETE FROM `uva_user` WHERE `uva_user`.`user_id` = 1;
DELETE FROM `uva_user` WHERE `uva_user`.`user_id` = ?;

SELECT `handle_table`.judge_code_id FROM `handle_table` WHERE `handle_table`.judge_name = 'uva' AND `handle_table`.handle = 'dipu_sust';
SELECT `handle_table`.judge_code_id FROM `handle_table` WHERE `handle_table`.judge_name = 'uva' AND `handle_table`.handle = ?;

INSERT INTO `uva_user` (`user_id`, `judge_code_id`) VALUES ('5', '1');
INSERT INTO `uva_user` (`user_id`, `judge_code_id`) VALUES (?, ?);

INSERT INTO `handle_table` (`judge_name`, `handle`) VALUES ('uva', 'dipu_sust');
INSERT INTO `handle_table` (`judge_name`, `handle`) VALUES ('uva', ?);

UPDATE `uva_user` SET `judge_code_id` = 4 WHERE `uva_user`.`user_id` = 5;
UPDATE `uva_user` SET `judge_code_id` = ? WHERE `uva_user`.`user_id` = ?;