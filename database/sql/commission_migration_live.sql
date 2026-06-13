-- =====================================================================
-- London Abason — Agents → Commission Users migration (LIVE / phpMyAdmin)
-- Run these statements on the production database.
-- BACK UP THE DATABASE FIRST.
-- Safe to run once; do not re-run.
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1) USERS: add commission hierarchy fields
-- ---------------------------------------------------------------------
ALTER TABLE `users`
  ADD COLUMN `commission_type` VARCHAR(20) NULL AFTER `role`,
  ADD COLUMN `parent_id` BIGINT UNSIGNED NULL AFTER `commission_type`,
  ADD COLUMN `booking_pct` DECIMAL(5,2) NULL AFTER `commission_rate`,
  ADD COLUMN `down_pct` DECIMAL(5,2) NULL AFTER `booking_pct`,
  ADD COLUMN `instalment_pct` DECIMAL(5,2) NULL AFTER `down_pct`;

ALTER TABLE `users`
  ADD INDEX `users_commission_type_index` (`commission_type`),
  ADD CONSTRAINT `users_parent_id_foreign`
      FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- ---------------------------------------------------------------------
-- 2) BOOKINGS: add commission scheme.
--    New bookings default to 'hierarchy'; existing bookings keep the
--    legacy flat-rate commission calculation.
-- ---------------------------------------------------------------------
ALTER TABLE `bookings`
  ADD COLUMN `commission_scheme` VARCHAR(20) NOT NULL DEFAULT 'hierarchy' AFTER `agent_commission`,
  ADD INDEX `bookings_commission_scheme_index` (`commission_scheme`);

-- Mark all pre-existing bookings as legacy flat scheme.
UPDATE `bookings` SET `commission_scheme` = 'flat';

-- ---------------------------------------------------------------------
-- 3) AGENT_PAYMENTS  ->  COMMISSION_PAYOUTS
--    Rename table, rename agent_id -> user_id, make booking_id nullable.
-- ---------------------------------------------------------------------
RENAME TABLE `agent_payments` TO `commission_payouts`;

-- agent_id -> user_id
ALTER TABLE `commission_payouts` DROP FOREIGN KEY `agent_payments_agent_id_foreign`;
ALTER TABLE `commission_payouts` CHANGE `agent_id` `user_id` BIGINT UNSIGNED NOT NULL;
ALTER TABLE `commission_payouts`
  ADD CONSTRAINT `commission_payouts_user_id_foreign`
      FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- booking_id -> nullable
ALTER TABLE `commission_payouts` DROP FOREIGN KEY `agent_payments_booking_id_foreign`;
ALTER TABLE `commission_payouts` MODIFY `booking_id` BIGINT UNSIGNED NULL;
ALTER TABLE `commission_payouts`
  ADD CONSTRAINT `commission_payouts_booking_id_foreign`
      FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

-- ---------------------------------------------------------------------
-- 4) COMMISSION_EARNINGS ledger (new table)
-- ---------------------------------------------------------------------
CREATE TABLE `commission_earnings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` BIGINT UNSIGNED NOT NULL,
  `booking_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,      -- beneficiary
  `seller_id` BIGINT UNSIGNED NOT NULL,    -- who made the sale
  `level` TINYINT UNSIGNED NOT NULL,       -- 0 = seller, 1 = immediate upline, ...
  `beneficiary_type` VARCHAR(20) NOT NULL,
  `pool_type` VARCHAR(20) NOT NULL,        -- booking | down | instalment
  `pool_rate` DECIMAL(5,2) NOT NULL,       -- 50 / 20 / 15 snapshot
  `percentage` DECIMAL(5,2) NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commission_earnings_user_id_pool_type_index` (`user_id`, `pool_type`),
  CONSTRAINT `commission_earnings_payment_id_foreign`
      FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_earnings_booking_id_foreign`
      FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_earnings_user_id_foreign`
      FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_earnings_seller_id_foreign`
      FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5) Rename admin permission key in stored JSON (manage_agents -> manage_commission_users)
-- ---------------------------------------------------------------------
UPDATE `users`
SET `permissions` = REPLACE(`permissions`, 'manage_agents', 'manage_commission_users')
WHERE `role` = 'admin' AND `permissions` LIKE '%manage_agents%';

-- =====================================================================
-- Done. Existing agents become "unassigned" commission users — open each
-- in the admin panel and set their Type + upline + percentages.
-- =====================================================================
