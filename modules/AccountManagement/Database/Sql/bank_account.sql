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
 
 Date: 15/12/2024 00:24:45
 */
-- ----------------------------
-- Sequence structure for bank_account_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bank_account_id_seq";

CREATE SEQUENCE "public"."bank_account_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for bank_account
-- ----------------------------
DROP TABLE IF EXISTS "public"."bank_account";

CREATE TABLE "public"."bank_account" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(6),
    "updated_at" timestamp(6),
    "id" int8 NOT NULL DEFAULT nextval('bank_account_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO
    "public"."bank_account"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        1,
        'Bank Account - HNB'
    );

-- ----------------------------
-- Primary Key structure for table bank_account
-- ----------------------------
ALTER TABLE
    "public"."bank_account"
ADD
    CONSTRAINT "bank_account_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bank_account_id_seq" OWNED BY "public"."bank_account"."id";

SELECT
    setval('"public"."bank_account_id_seq"', 1, true);