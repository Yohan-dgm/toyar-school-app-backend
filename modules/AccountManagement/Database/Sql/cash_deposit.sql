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
-- Sequence structure for cash_deposit_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cash_deposit_id_seq";

CREATE SEQUENCE "public"."cash_deposit_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for cash_deposit
-- ----------------------------
DROP TABLE IF EXISTS "public"."cash_deposit";

CREATE TABLE "public"."cash_deposit" (
    "id" int8 NOT NULL DEFAULT nextval('cash_deposit_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "bank_account_id" int8,
    "cash_deposit_date" date,
    "is_attached" bool,
    "total_amount" numeric(15, 2),
    "received_by" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Primary Key structure for table cash_deposit
-- ----------------------------
ALTER TABLE
    "public"."cash_deposit"
ADD
    CONSTRAINT "cash_deposit_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cash_deposit_id_seq" OWNED BY "public"."cash_deposit"."id";

SELECT
    setval('"public"."cash_deposit_id_seq"', 1, false);