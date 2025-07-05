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
 
 Date: 09/12/2024 15:07:41
 */
-- ----------------------------
-- Sequence structure for school_holiday_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_holiday_id_seq";

CREATE SEQUENCE "public"."school_holiday_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_holiday
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_holiday";

CREATE TABLE "public"."school_holiday" (
    "title" varchar(255) COLLATE "pg_catalog"."default",
    "date" date,
    "description" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('school_holiday_id_seq' :: regclass)
);

-- ----------------------------
-- Records of school_holiday
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table school_holiday
-- ----------------------------
ALTER TABLE
    "public"."school_holiday"
ADD
    CONSTRAINT "school_holiday_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_holiday_id_seq" OWNED BY "public"."school_holiday"."id";

SELECT
    setval('"public"."school_holiday_id_seq"', 1, false);