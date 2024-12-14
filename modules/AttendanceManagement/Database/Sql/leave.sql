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
 
 Date: 09/12/2024 11:35:59
 */
-- ----------------------------
-- Sequence structure for leave_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."leave_id_seq";

CREATE SEQUENCE "public"."leave_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for leave
-- ----------------------------
DROP TABLE IF EXISTS "public"."leave";

CREATE TABLE "public"."leave" (
    "id" int8 NOT NULL DEFAULT nextval('leave_id_seq' :: regclass),
    "employee_id" int8,
    "leave_type_id" int8,
    "leave_duration_type" varchar(255) COLLATE "pg_catalog"."default",
    "leave_date" date,
    "leave_period_start_date" date,
    "leave_period_end_date" date,
    "next_reporting_date" date,
    "leave_period_working_days_count" numeric(15, 1),
    "leave_status_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of leave
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table leave
-- ----------------------------
ALTER TABLE
    "public"."leave"
ADD
    CONSTRAINT "leave_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."leave_id_seq" OWNED BY "public"."leave"."id";

SELECT
    setval('"public"."leave_id_seq"', 1, false);