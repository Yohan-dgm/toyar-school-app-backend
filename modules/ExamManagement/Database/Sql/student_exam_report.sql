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
-- Sequence structure for student_exam_report_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_exam_report_id_seq";

CREATE SEQUENCE "public"."student_exam_report_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_exam_report
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_exam_report";

CREATE TABLE "public"."student_exam_report" (
    "id" int8 NOT NULL DEFAULT nextval('student_exam_report_id_seq' :: regclass),
    "student_id" int8,
    "exam_quiz_id" int8,
    "scheduling_examination_id" int8,
    "class_teacher_comment" text,
    "class_rank" int8,
    "student_average" numeric(15, 2),
    "class_average" numeric(15, 2),
    "aggregate_of_mark" numeric(15, 2),
    'grade_level_name' varchar(255) COLLATE "pg_catalog"."default",
    'grade_level_class_id' int8,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_exam_report
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table student_exam_report
-- ----------------------------
ALTER TABLE
    "public"."student_exam_report"
ADD
    CONSTRAINT "student_exam_report_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_exam_report_id_seq" OWNED BY "public"."student_exam_report"."id";

SELECT
    setval(
        '"public"."student_exam_report_id_seq"',
        1,
        false
    );