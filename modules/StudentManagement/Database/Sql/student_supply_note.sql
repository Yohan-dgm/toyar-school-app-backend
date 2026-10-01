/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for student_supply_note_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_supply_note_id_seq";

CREATE SEQUENCE "public"."student_supply_note_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_supply_note
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_supply_note";

CREATE TABLE "public"."student_supply_note" (
    "id" int8 NOT NULL DEFAULT nextval('student_supply_note_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "student_id" int8,
    "student_supply_id" int8,
    "quantity" numeric(15, 2),
    "period_start_date" date,
    "period_end_date" date,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "student_supply_note_status_id" int8
);

-- ----------------------------
-- Primary Key structure for table student_supply_note
-- ----------------------------
ALTER TABLE
    "public"."student_supply_note"
ADD
    CONSTRAINT "student_supply_note_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_supply_note_id_seq" OWNED BY "public"."student_supply_note"."id";

SELECT
    setval(
        '"public"."student_supply_note_id_seq"',
        1,
        false
    );