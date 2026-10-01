/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for payment_voucher_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."payment_voucher_id_seq";

CREATE SEQUENCE "public"."payment_voucher_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for payment_voucher
-- ----------------------------
DROP TABLE IF EXISTS "public"."payment_voucher";

CREATE TABLE "public"."payment_voucher" (
    "id" int8 NOT NULL DEFAULT nextval('payment_voucher_id_seq' :: regclass),
    "payment_voucher_type" varchar(255) COLLATE "pg_catalog"."default",
    "purchase_order_id" int8,
    "expense_note_id" int8,
    "amount" numeric(15, 2),
    "narration" text COLLATE "pg_catalog"."default",
    "payment_method" varchar(255) COLLATE "pg_catalog"."default",
    "cash_account_id" int8,
    "cash_paid_date" date,
    "bank_account_id" int8,
    "bank_transfer_date" date,
    "bank_transfer_reference_number" varchar(255) COLLATE "pg_catalog"."default",
    "check_type" varchar(255) COLLATE "pg_catalog"."default",
    "check_bank_account_id" int8,
    "check_number" varchar(255) COLLATE "pg_catalog"."default",
    "check_issued_date" date,
    "check_date" date,
    "is_active" bool,
    "payment_issued_by_id" int8,
    "payment_issued_date" date,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "is_reconciled" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table payment_voucher
-- ----------------------------
ALTER TABLE
    "public"."payment_voucher"
ADD
    CONSTRAINT "payment_voucher_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."payment_voucher_id_seq" OWNED BY "public"."payment_voucher"."id";

SELECT
    setval(
        '"public"."payment_voucher_id_seq"',
        1,
        false
    );