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
-- Sequence structure for exam_quiz_item_student_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."exam_quiz_item_student_pivot_id_seq";

CREATE SEQUENCE "public"."exam_quiz_item_student_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for exam_quiz_item_student_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."exam_quiz_item_student_pivot";

CREATE TABLE "public"."exam_quiz_item_student_pivot" (
    "id" int8 NOT NULL DEFAULT nextval(
        'exam_quiz_item_student_pivot_id_seq' :: regclass
    ),
    "exam_quiz_item_id" int8,
    "student_id" int8,
    "marks" numeric(15, 2),
    "is_absent" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table exam_quiz_item_student_pivot
-- ----------------------------
ALTER TABLE
    "public"."exam_quiz_item_student_pivot"
ADD
    CONSTRAINT "exam_quiz_item_student_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."exam_quiz_item_student_pivot_id_seq" OWNED BY "public"."exam_quiz_item_student_pivot"."id";

SELECT
    setval(
        '"public"."exam_quiz_item_student_pivot_id_seq"',
        1,
        false
    );