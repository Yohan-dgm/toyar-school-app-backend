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
 
 Date: 29/08/2025 10:00:00
 */

-- ----------------------------
-- Sequence structure for student_achievement_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_achievement_id_seq";

CREATE SEQUENCE "public"."student_achievement_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_achievement
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_achievement";

CREATE TABLE "public"."student_achievement" (
    "id" int8 NOT NULL DEFAULT nextval(
        'student_achievement_id_seq' :: regclass
    ),
    "student_id" int8 NOT NULL,
    "achievement_type" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "description" text,
    "is_active" bool DEFAULT true,
    "start_date" date,
    "end_date" date,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_achievement
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table student_achievement
-- ----------------------------
ALTER TABLE
    "public"."student_achievement"
ADD
    CONSTRAINT "student_achievement_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_achievement_id_seq" OWNED BY "public"."student_achievement"."id";

SELECT
    setval(
        '"public"."student_achievement_id_seq"',
        1,
        false
    );