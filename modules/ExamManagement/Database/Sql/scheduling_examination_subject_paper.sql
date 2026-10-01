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
-- Sequence structure for scheduling_examination_subject_paper_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."scheduling_examination_subject_paper_id_seq";

CREATE SEQUENCE "public"."scheduling_examination_subject_paper_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for scheduling_examination_subject_paper
-- ----------------------------
DROP TABLE IF EXISTS "public"."scheduling_examination_subject_paper";

CREATE TABLE "public"."scheduling_examination_subject_paper" (
    "id" int8 NOT NULL DEFAULT nextval(
        'scheduling_examination_subject_paper_id_seq' :: regclass
    ),
    "scheduling_examination_grade_subject_id" int8,
    "paper_type" varchar(255) COLLATE "pg_catalog"."default",
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "overall_mark" numeric(15, 2),
    "duration_hours" numeric(15, 2),
    "duration_minutes" numeric(15, 2),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table scheduling_examination_subject_paper
-- ----------------------------
ALTER TABLE
    "public"."scheduling_examination_subject_paper"
ADD
    CONSTRAINT "scheduling_examination_subject_paper_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."scheduling_examination_subject_paper_id_seq" OWNED BY "public"."scheduling_examination_subject_paper"."id";

SELECT
    setval(
        '"public"."scheduling_examination_subject_paper_id_seq"',
        1,
        false
    );