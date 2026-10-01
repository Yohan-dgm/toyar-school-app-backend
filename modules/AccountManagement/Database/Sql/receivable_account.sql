/*
 Navicat Premium Data Transfer
 
 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 10/12/2024 06:25:55
 */
-- ----------------------------
-- Sequence structure for receivable_account_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."receivable_account_id_seq";

CREATE SEQUENCE "public"."receivable_account_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for receivable_account
-- ----------------------------
DROP TABLE IF EXISTS "public"."receivable_account";

CREATE TABLE "public"."receivable_account" (
    "id" int8 NOT NULL DEFAULT nextval('receivable_account_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table receivable_account
-- ----------------------------
ALTER TABLE
    "public"."receivable_account"
ADD
    CONSTRAINT "receivable_account_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."receivable_account_id_seq" OWNED BY "public"."receivable_account"."id";

SELECT
    setval(
        '"public"."receivable_account_id_seq"',
        1,
        false
    );