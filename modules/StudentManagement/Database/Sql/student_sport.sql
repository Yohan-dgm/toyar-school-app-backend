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
 
 Date: 09/12/2024 09:41:15
 */
-- ----------------------------
-- Sequence structure for student_sport_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_sport_id_seq";

CREATE SEQUENCE "public"."student_sport_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_sport
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_sport";

CREATE TABLE "public"."student_sport" (
    "student_id" int8 NOT NULL,
    "sport_id" int8 NOT NULL,
    "coach_id" int8,
    "enrolled_date" date NOT NULL DEFAULT CURRENT_DATE,
    "left_date" date,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "status" bool,
    "id" int8 NOT NULL DEFAULT nextval(
        'student_sport_id_seq' :: regclass
    )
);

-- ----------------------------
-- Records of student_sport
-- ----------------------------
 
-- ----------------------------
-- Primary Key structure for table student_sport
-- ----------------------------
ALTER TABLE
    "public"."student_sport"
ADD
    CONSTRAINT "student_sport_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_sport_id_seq" OWNED BY "public"."student_sport"."id";

SELECT
    setval(
        '"public"."student_sport_id_seq"',
        1,
        false
    );