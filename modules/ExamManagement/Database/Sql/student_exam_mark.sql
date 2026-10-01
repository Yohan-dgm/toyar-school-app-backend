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
-- Sequence structure for student_exam_mark_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_exam_mark_id_seq";

CREATE SEQUENCE "public"."student_exam_mark_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_exam_mark
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_exam_mark";

CREATE TABLE "public"."student_exam_mark" (
    "id" int8 NOT NULL DEFAULT nextval('student_exam_mark_id_seq' :: regclass),
    "scheduling_examination_grade_id" int8,
    "exam_quiz_item_id" int8,
    "student_id" int8,
    "subject_total_mark" numeric(15, 2),
    "subject_overall_mark_percentage" numeric(15, 2),
    "subject_comment" text,
    "present_type" varchar(255) COLLATE "pg_catalog"."default",
    "grading" varchar(255) COLLATE "pg_catalog"."default",
    "mark_added_by" int8,
    "is_active" bool,
    "is_mark_added" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_exam_mark
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table student_exam_mark
-- ----------------------------
ALTER TABLE
    "public"."student_exam_mark"
ADD
    CONSTRAINT "student_exam_mark_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_exam_mark_id_seq" OWNED BY "public"."student_exam_mark"."id";

SELECT
    setval(
        '"public"."student_exam_mark_id_seq"',
        1,
        false
    );