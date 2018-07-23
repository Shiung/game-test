
--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `pwd_wrong_count`, `login_permission`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'liors', '$2y$10$A8I1ktHRJ5jmAj3vQviNVeWWQy0OQzvbNzLNxQAr4vII4kTL..t/y', 0, '1', 'admin', 'GHKcJHsOTG5xIFftAzY1ZB1z624Ju7nKzmQGRZVeTFiG0RzvXnNIfDbeG6DQ', '2017-09-14 14:24:49', '2017-09-16 02:26:00'),
(2, 'master-admin', '$2y$10$pGePxdfRkkPsnGpr7ytSA.9tdp/coHOheoBJVPkru1.sPbzlKxCpa', 0, '1', 'admin', NULL, '2017-09-15 19:02:39', '2017-09-15 19:02:39'),
(3, 'test', '$2y$10$OotCwkVM1P7.CNEkkz8I4uk/VxFiQeTp62y1S0kb8FhDUjUwj9tHC', 0, '1', 'admin_member', NULL, '2017-09-16 07:08:11', '2017-09-16 07:08:11');
--
-- 資料表的匯出資料 `admins`
--

INSERT INTO `admins` (`id`, `type`, `name`, `password`, `username`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0', 'LIORS管理員', '$2y$10$A8I1ktHRJ5jmAj3vQviNVeWWQy0OQzvbNzLNxQAr4vII4kTL..t/y', 'liors', '3sT8OfNZvQF0Gxpsqwg4PASXtT1DUy1DUHJyCJbEZVpbCFxf8LIV7Wdh1NMW', '2017-09-15 06:25:14', '2017-09-15 06:27:29');
INSERT INTO `admins` (`id`, `type`, `name`, `password`, `username`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', '0', '最高管理員', '$2y$10$pGePxdfRkkPsnGpr7ytSA.9tdp/coHOheoBJVPkru1.sPbzlKxCpa', 'master-admin', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

--
-- 資料表的匯出資料 `members`
--


INSERT INTO `members` (`user_id`, `member_number`, `name`, `phone`, `bank_code`, `bank_account`, `recommender_id`, `confirm_status`, `confirmed_at`, `reset_pwd_status`, `reset_pwd_at`, `place_status`, `placed_at`, `created_at`, `updated_at`) VALUES
(3, '', '會員的頭兒', '0912345678', NULL, NULL, NULL, '0', NULL, '0', NULL, '0', NULL, '2017-09-26 02:38:10', '2017-09-26 02:38:10');
--
-- 資料表的匯出資料 `roles`
--



INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'LIORS超級管理員', '給工程師登入的', NULL, NULL),
(2, 'master-admin', '最高管理員', '給業主登入的', NULL, NULL),
(3, 'banner-preview', 'BANNER瀏覽', NULL, NULL, NULL),
(4, 'banner-write', 'BANNER管理', NULL, NULL, NULL),
(5, 'page-preview', '頁面內容瀏覽', NULL, NULL, NULL),
(6, 'page-write', '頁面內容管理', NULL, NULL, NULL),
(7, 'news-preview', '公告瀏覽', NULL, NULL, NULL),
(8, 'news-write', '公告管理', NULL, NULL, NULL),
(9, 'marquee-preview', '跑馬燈瀏覽', NULL, NULL, NULL),
(10, 'marquee-write', '跑馬燈管理', NULL, NULL, NULL),
(11, 'admin-activity-preview', '後台操作記錄瀏覽', NULL, NULL, NULL),
(12, 'parameter-preview', '參數設置瀏覽', NULL, NULL, NULL),
(13, 'parameter-write', '參數設置管理', NULL, NULL, NULL),
(14, 'member-preview', '會員瀏覽', NULL, NULL, NULL),
(15, 'member-write', '會員管理', NULL, NULL, NULL),
(16, 'charge-preview', '現金碼購買瀏覽', NULL, NULL, NULL),
(17, 'charge-write', '現金碼購買管理', NULL, NULL, NULL),
(18, 'withdrawal-preview', '出金申請瀏覽', NULL, NULL, NULL),
(19, 'withdrawal-write', '出金申請購買管理', NULL, NULL, NULL),
(20, 'product-preview', '商品瀏覽', NULL, NULL, NULL),
(21, 'product-write', '商品管理', NULL, NULL, NULL),
(22, 'company-transfer-preview', '公司轉帳瀏覽', NULL, NULL, NULL),
(23, 'company-transfer-write', '公司轉帳管理', NULL, NULL, NULL),
(24, 'sport-preview', '遊戲瀏覽', NULL, NULL, NULL),
(25, 'sport-write', '遊戲管理', NULL, NULL, NULL),
(26, 'give-product-preview', '贈送商品瀏覽', NULL, NULL, NULL),
(27, 'give-product-write', '贈送商品管理', NULL, NULL, NULL),
(28, 'share-preview', '權利碼發行瀏覽', NULL, NULL, NULL),
(29, 'share-write', '權利碼發行管理', NULL, NULL, NULL),
(30, 'board-message-preview', '留言板瀏覽', NULL, NULL, NULL),
(31, 'board-message-write', '留言板管理', NULL, NULL, NULL),
(32, 'schedule-record-preview', '排程紀錄', NULL, NULL, NULL),
(33, 'login-record-preview', '會員登入紀錄', NULL, NULL, NULL),
(34, 'product-use-record-preview', '商品使用紀錄', NULL, NULL, NULL),
(35, 'transaction-preview', '商品交易紀錄', NULL, NULL, NULL),
(36, 'organization-betrecord-preview', '組織下注歷程', NULL, NULL, NULL),
(37, 'member-betrecord-preview', '會員下注紀錄', NULL, NULL, NULL),
(38, 'member-account-preview', '會員帳戶明細查詢', NULL, NULL, NULL),
(39, 'statistic-preview', '統計報表', NULL, NULL, NULL);

INSERT INTO  `gold_game`.`roles` (
`id` ,
`name` ,
`display_name` ,
`description` ,
`created_at` ,
`updated_at`
)
VALUES (
NULL ,  'transfer-record-preview',  '轉帳紀錄', NULL , NULL , NULL
);


INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ('1', '1'), ('2', '2');

INSERT INTO `parameters` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'sms_expire_second', '600', '2017-09-25 18:38:10', '2017-09-25 18:38:10'),
(2, 'tree_parent', '4', '2017-09-25 18:38:10', '2017-10-12 08:29:43'),
(3, 'sport_starttime_539', '20:00', '2017-10-04 18:06:35', '2017-10-04 18:06:35'),
(4, 'sport_game_starttime_539', '14:00', '2017-10-04 18:06:35', '2017-10-12 07:58:07'),
(5, 'one_ratio_539', '1', '2017-10-04 18:57:15', '2017-10-12 08:30:13'),
(6, 'two_ratio_539', '2', '2017-10-04 18:57:15', '2017-10-04 18:57:15'),
(7, 'three_ratio_539', '3', '2017-10-04 18:57:15', '2017-10-04 18:57:15'),
(8, 'bet_status_closetime', '10', '2017-10-10 02:18:39', '2017-10-10 02:18:39'),
(9, 'bet_opentime', '14:00', '2017-10-11 07:32:02', '2017-10-11 07:32:02'),
(10, 'daily_interest_period', '1', '2017-10-12 07:56:39', '2017-10-12 07:56:39'),
(11, 'bet_bonus_interest', '0.01', '2017-10-12 07:56:39', '2017-10-12 07:56:39'),
(12, 'bet_bonus_level', '4', '2017-10-12 07:57:13', '2017-10-12 07:57:13'),
(13, 'bet_bonus_period', '7', '2017-10-12 07:57:13', '2017-10-12 07:57:13'),
(14, 'recommend_bonus_interest', '0.05', '2017-10-12 07:57:23', '2017-10-12 07:57:23'),
(15, 'recommend_bonus_period', '1', '2017-10-12 07:57:23', '2017-10-12 07:57:23'),
(16, 'tree_bonus_interest', '0.01', '2017-10-12 07:57:45', '2017-10-12 07:57:45'),
(17, 'tree_bonus_level', '4', '2017-10-12 07:57:45', '2017-10-12 07:57:45'),
(18, 'tree_bonus_period', '7', '2017-10-12 07:57:52', '2017-10-12 07:57:52'),
(19, 'daily_interest_schedule', '14:00', '2017-10-12 07:57:52', '2017-10-12 07:57:52'),
(20, 'daily_recommend_schedule', '14:00', '2017-10-12 07:57:52', '2017-10-12 07:57:52'),
(21, 'monthly_bet_schedule', '14', '2017-10-12 07:57:52', '2017-10-13 01:46:30'),
(22, 'monthly_tree_schedule', '14', '2017-10-12 07:57:52', '2017-10-13 01:46:35'),
(23, 'search_parent_limit', '4', '2017-10-13 01:20:41', '2017-10-13 01:20:41'),
(24, 'interest_cleartime', '14:30', '2017-10-13 01:20:41', '2017-10-13 01:20:41'),
(25, 'block_member_period', '7', '2017-10-13 01:20:41', '2017-10-13 01:20:41');

INSERT INTO `gold_game`.`parameters` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'maintenance_end', '15:00', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO `gold_game`.`product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES ('1', '轉帳卡', '用於會員間轉帳', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), ('2', '權利碼', '新增權利碼至帳戶，權利碼會影響領取中心可領取總額', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `gold_game`.`product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES ('3', '專屬權利碼', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), ('4', '會員卡', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `gold_game`.`product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES ('5', '推薦卡', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
--
-- 資料表的匯出資料 `product_categories`
--
UPDATE  `gold_game`.`product_categories` SET  `description` =  '會員間可使用轉移卡進行轉帳' WHERE  `product_categories`.`id` =1;

UPDATE  `gold_game`.`product_categories` SET  `description` =  '取得權利碼帳戶，以增加簽到中心可領取額度。' WHERE  `product_categories`.`id` =2;

UPDATE  `gold_game`.`product_categories` SET  `description` =  '買回下注輸掉的權利碼' WHERE  `product_categories`.`id` =3;

UPDATE  `gold_game`.`product_categories` SET  `description` =  '提升每日利息' WHERE  `product_categories`.`id` =4;

UPDATE  `gold_game`.`product_categories` SET  `description` =  '用來新增下線，註冊新會員' WHERE  `product_categories`.`id` =5;

INSERT INTO `gold_game`.`shares` (`id`, `all_share`, `sell_share`, `created_at`, `updated_at`) VALUES (NULL, '0.00', '0.00', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
--
-- 資料表的匯出資料 `sport_categories`
--
INSERT INTO `gold_game`.`products` (`id`, `name`, `product_category_id`, `price`, `status`, `quantity`, `subtract`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '權利碼', '2', '100.00', '1', '1', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL), (NULL, '專屬權利碼', '3', '100.00', '1', '1', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);
INSERT INTO `sport_categories` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, '美國職棒(MLB)', 'usa_baseball', '2017-09-26 02:38:10', '2017-09-28 03:27:31'),
(2, '中華職棒', 'tw_baseball', '2017-09-26 02:38:10', '2017-09-28 03:27:31'),
(3, '彩球539', 'lottery539', '2017-09-26 02:38:10', '2017-09-28 03:27:31');

INSERT INTO `news` (`id`, `title`, `content`, `status`, `type`, `post_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', '<p>11</p>\r\n', '1', 'system_alert', '2017-09-22', '2017-09-22 12:08:10', '2017-09-22 12:09:12', NULL);

INSERT INTO `accounts` (`id`, `member_id`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(1, 3, '1', '100.00', '2017-09-26 03:22:46', '2017-09-26 03:27:57'),
(2, 3, '2', '0.00', '2017-09-26 03:22:46', '2017-09-26 03:22:46'),
(3, 3, '3', '0.00', '2017-09-26 03:25:31', '2017-09-26 03:25:31'),
(4, 3, '4', '0.00', '2017-09-26 03:25:31', '2017-09-26 03:25:31'),
(5, 3, '5', '0.00', '2017-09-26 03:25:40', '2017-09-26 03:25:40');

INSERT INTO `gold_game`.`trees` (`member_id`, `parent_id`, `position`, `created_at`) VALUES ('3', NULL, '1', CURRENT_TIMESTAMP);