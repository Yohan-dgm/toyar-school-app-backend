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
-- Sequence structure for exam_private_candidate_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."exam_private_candidate_id_seq";

CREATE SEQUENCE "public"."exam_private_candidate_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for exam_private_candidate
-- ----------------------------
DROP TABLE IF EXISTS "public"."exam_private_candidate";

CREATE TABLE "public"."exam_private_candidate" (
    "id" int8 NOT NULL DEFAULT nextval('exam_private_candidate_id_seq' :: regclass),
    "exam_private_candidate_number_prefix" varchar COLLATE "pg_catalog"."default",
    "exam_private_candidate_number_current_year" varchar COLLATE "pg_catalog"."default",
    "exam_private_candidate_number_digits" int8,
    "exam_private_candidate_number" varchar(255) COLLATE "pg_catalog"."default",
    "gender" varchar(255) COLLATE "pg_catalog"."default",
    "full_name" varchar(255) COLLATE "pg_catalog"."default",
    "full_name_with_title" text COLLATE "pg_catalog"."default",
    "phone" text COLLATE "pg_catalog"."default",
    "email" text COLLATE "pg_catalog"."default",
    "address" text COLLATE "pg_catalog"."default",
    "student_admission_source_id" int8,
    "student_admission_source_other" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of exam_private_candidate
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table exam_private_candidate
-- ----------------------------
ALTER TABLE
    "public"."exam_private_candidate"
ADD
    CONSTRAINT "exam_private_candidate_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."exam_private_candidate_id_seq" OWNED BY "public"."exam_private_candidate"."id";

SELECT
    setval(
        '"public"."exam_private_candidate_id_seq"',
        1,
        false
    );