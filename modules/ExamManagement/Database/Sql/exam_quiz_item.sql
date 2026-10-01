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
-- Sequence structure for exam_quiz_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."exam_quiz_item_id_seq";

CREATE SEQUENCE "public"."exam_quiz_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for exam_quiz_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."exam_quiz_item";

CREATE TABLE "public"."exam_quiz_item" (
    "id" int8 NOT NULL DEFAULT nextval('exam_quiz_item_id_seq' :: regclass),
    "exam_quiz_id" int8,
    "scheduling_examination_grade_id" int8,
    "subject_id" int8,
    "subject_start_date" Date,
    "subject_end_date" Date,
    "subject_start_time" varchar(255) COLLATE "pg_catalog"."default",
    "subject_end_time" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of exam_quiz_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table exam_quiz_item
-- ----------------------------
ALTER TABLE
    "public"."exam_quiz_item"
ADD
    CONSTRAINT "exam_quiz_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."exam_quiz_item_id_seq" OWNED BY "public"."exam_quiz_item"."id";

SELECT
    setval(
        '"public"."exam_quiz_item_id_seq"',
        1,
        false
    );