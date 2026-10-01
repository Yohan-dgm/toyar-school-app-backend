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
-- Sequence structure for student_subject_mark_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_subject_mark_id_seq";

CREATE SEQUENCE "public"."student_subject_mark_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_subject_mark
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_subject_mark";

CREATE TABLE "public"."student_subject_mark" (
    "id" int8 NOT NULL DEFAULT nextval('student_subject_mark_id_seq' :: regclass),
    "student_exam_mark_id" int8,
    "mark_type" varchar(255) COLLATE "pg_catalog"."default",
    "mark" numeric(15, 2),
    "overall_mark" numeric(15, 2),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_subject_mark
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table student_subject_mark
-- ----------------------------
ALTER TABLE
    "public"."student_subject_mark"
ADD
    CONSTRAINT "student_subject_mark_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_subject_mark_id_seq" OWNED BY "public"."student_subject_mark"."id";

SELECT
    setval(
        '"public"."student_subject_mark_id_seq"',
        1,
        false
    );