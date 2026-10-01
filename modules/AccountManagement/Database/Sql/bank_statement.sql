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
-- Sequence structure for bank_statement_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bank_statement_id_seq";

CREATE SEQUENCE "public"."bank_statement_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for bank_statement
-- ----------------------------
DROP TABLE IF EXISTS "public"."bank_statement";

CREATE TABLE "public"."bank_statement" (
    "id" int8 NOT NULL DEFAULT nextval('bank_statement_id_seq' :: regclass),
    "bank_account_id" int8,
    "transaction_date" date,
    "transaction_type" varchar(255) COLLATE "pg_catalog"."default",
    "amount" numeric(15, 2),
    "transaction_reference_number" varchar(255) COLLATE "pg_catalog"."default",
    "transaction_details" varchar(255) COLLATE "pg_catalog"."default",
    "running_balance" numeric(15, 2),
    "is_reconciled" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of bank_statement
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table bank_statement
-- ----------------------------
ALTER TABLE
    "public"."bank_statement"
ADD
    CONSTRAINT "bank_statement_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bank_statement_id_seq" OWNED BY "public"."bank_statement"."id";

SELECT
    setval(
        '"public"."bank_statement_id_seq"',
        1,
        false
    );