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
-- Sequence structure for school_fee_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_fee_id_seq";

CREATE SEQUENCE "public"."school_fee_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_fee
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_fee";

CREATE TABLE "public"."school_fee" (
    "id" int8 NOT NULL DEFAULT nextval('school_fee_id_seq' :: regclass),
    "school_fee_type" varchar(255) COLLATE "pg_catalog"."default",
    "name" varchar(255) COLLATE "pg_catalog"."default",
    --Admission Fee, Refundable Deposit, Term Fee, Sport Fee
    "grade_level_id" int8,
    --Admission Fee
    "term_id" int8,
    "amount" numeric(15, 2),
    "is_active" bool,
    "version" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of school_fee
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table school_fee
-- ----------------------------
ALTER TABLE
    "public"."school_fee"
ADD
    CONSTRAINT "school_fee_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_fee_id_seq" OWNED BY "public"."school_fee"."id";

SELECT
    setval(
        '"public"."school_fee_id_seq"',
        1,
        false
    );