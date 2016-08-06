SELECT
  `contest_problem_list`.`problem_id`,
  `contest_problem_list`.`difficulty`,
  `solve_list`.`student_id`,
  `solve_list`.`no_submission`,
  `solve_list`.`solve_flag`,
  `solve_list`.`time`
FROM
  `contest_problem_list`
JOIN
  `solve_list` ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE
  `contest_problem_list`.`contest_id` IN(
  SELECT
    `contest_list`.`contest_id`
  FROM
    `contest_list`
  WHERE
    `contest_list`.`course_id` = 12
)



SELECT
  `solve_list`.`student_id`,
  SUM(`contest_problem_list`.`difficulty`*`solve_list`.`solve_flag`) AS points,
  SUM((`solve_list`.`no_submission`*`solve_list`.`solve_flag`*1200)+`solve_list`.`time`) AS penalty,
  SUM(`solve_list`.`solve_flag`) AS sloved
FROM
  `contest_problem_list`
JOIN
  `solve_list` ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
WHERE
  `contest_problem_list`.`contest_id` IN(
  SELECT
    `contest_list`.`contest_id`
  FROM
    `contest_list`
  WHERE
    `contest_list`.`course_id` = 12
)
GROUP BY `solve_list`.`student_id`



SELECT
  `user_table`.`user_name`,
  `enroll_table`.`enroll_id`,
  `solve_list`.`student_id`,
  SUM(
    `contest_problem_list`.`difficulty` * `solve_list`.`solve_flag`
  ) AS points,
  SUM(
    (
      `solve_list`.`no_submission` * `solve_list`.`solve_flag` * 1200
    ) + `solve_list`.`time`
  ) AS penalty,
  SUM(`solve_list`.`solve_flag`) AS sloved
FROM
  `contest_problem_list`
JOIN
  `solve_list` ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
JOIN `enroll_table` ON
  `enroll_table`.`student_id` = `solve_list`.`student_id` AND `enroll_table`.`course_id` = 12
JOIN
  `user_table` ON `user_table`.`user_id` = `solve_list`.`student_id`
WHERE
  `contest_problem_list`.`contest_id` IN(
  SELECT
    `contest_list`.`contest_id`
  FROM
    `contest_list`
  WHERE
    `contest_list`.`course_id` = 12
)
GROUP BY
  `solve_list`.`student_id`
ORDER BY points DESC, penalty ASC