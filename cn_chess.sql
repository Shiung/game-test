INSERT INTO `gold_game`.`parameters` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'cn_chess_interval', '5', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'cn_chess_resttime ', '90', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `gold_game`.`parameters` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES 
(NULL, 'cn_chess_one_ratio', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, 'cn_chess_two_ratio', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, 'cn_virtual_cash_ratio', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, 'cn_share_ratio', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, 'cn_red_ratio ', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, 'cn_black_ration ', '0.95', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

CREATE TABLE `cn_chess_numbers` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` tinyint(10) UNSIGNED NOT NULL,
  `sport_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `cn_chess_numbers`
--
ALTER TABLE `cn_chess_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cn_chess_numbers_sport_id_foreign` (`sport_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `cn_chess_numbers`
--
ALTER TABLE `cn_chess_numbers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `cn_chess_numbers`
--
ALTER TABLE `cn_chess_numbers`
  ADD CONSTRAINT `cn_chess_numbers_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `sport_game_cn_chess_nums` (
  `id` int(10) UNSIGNED NOT NULL,
  `sport_game_id` int(10) UNSIGNED NOT NULL,
  `one_ratio` double NOT NULL,
  `two_ratio` double NOT NULL,
  `virtual_cash_ratio` double NOT NULL,
  `share_ratio` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_nums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sport_game_cn_chess_nums_sport_game_id_foreign` (`sport_game_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_nums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_nums`
  ADD CONSTRAINT `sport_game_cn_chess_nums_sport_game_id_foreign` FOREIGN KEY (`sport_game_id`) REFERENCES `sport_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `sport_game_cn_chess_colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `sport_game_id` int(10) UNSIGNED NOT NULL,
  `red_ratio` double NOT NULL,
  `black_ratio` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sport_game_cn_chess_colors_sport_game_id_foreign` (`sport_game_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `sport_game_539`
--
ALTER TABLE `sport_game_cn_chess_colors`
  ADD CONSTRAINT `sport_game_cn_chess_colors_sport_game_id_foreign` FOREIGN KEY (`sport_game_id`) REFERENCES `sport_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_bet_records` CHANGE `type` `type` ENUM( '1', '2', '3', '4', '5' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

CREATE TABLE `sport_bet_cn_chess_nums` (
  `sport_bet_record_id` int(10) UNSIGNED NOT NULL,
  `gamble` tinyint(3) UNSIGNED NOT NULL,
  `one_ratio` double NOT NULL,
  `two_ratio` double NOT NULL,
  `virtual_cash_ratio` double NOT NULL,
  `share_ratio` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `sport_bet_539`
--
ALTER TABLE `sport_bet_cn_chess_nums`
  ADD KEY `sport_bet_cn_chess_nums_sport_bet_record_id_foreign` (`sport_bet_record_id`);

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `sport_bet_539`
--
ALTER TABLE `sport_bet_cn_chess_nums`
  ADD CONSTRAINT `sport_bet_cn_chess_nums_sport_bet_record_id_foreign` FOREIGN KEY (`sport_bet_record_id`) REFERENCES `sport_bet_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `sport_bet_cn_chess_colors` (
  `sport_bet_record_id` int(10) UNSIGNED NOT NULL,
  `gamble` tinyint(3) UNSIGNED NOT NULL,
  `red_ratio` double NOT NULL,
  `black_ratio` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `sport_bet_539`
--
ALTER TABLE `sport_bet_cn_chess_colors`
  ADD KEY `sport_bet_cn_chess_colors_sport_bet_record_id_foreign` (`sport_bet_record_id`);

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `sport_bet_539`
--
ALTER TABLE `sport_bet_cn_chess_colors`
  ADD CONSTRAINT `sport_bet_cn_chess_colors_sport_bet_record_id_foreign` FOREIGN KEY (`sport_bet_record_id`) REFERENCES `sport_bet_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

