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
-- Sequence structure for student_guardian_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_guardian_id_seq";

CREATE SEQUENCE "public"."student_guardian_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_guardian
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_guardian";

CREATE TABLE "public"."student_guardian" (
    "id" int8 NOT NULL DEFAULT nextval('student_id_seq' :: regclass),
    "full_name" varchar(255) COLLATE "pg_catalog"."default",
    "id_type" varchar(255) COLLATE "pg_catalog"."default",
    "nic_number" varchar(255) COLLATE "pg_catalog"."default",
    "passport_number" varchar(255) COLLATE "pg_catalog"."default",
    "phone" varchar(255) COLLATE "pg_catalog"."default",
    "whatsapp" varchar(255) COLLATE "pg_catalog"."default",
    "email" varchar(255) COLLATE "pg_catalog"."default",
    "occupation" text COLLATE "pg_catalog"."default",
    "place_of_work" text COLLATE "pg_catalog"."default",
    "monthly_income" varchar(255) COLLATE "pg_catalog"."default",
    "guardian_type" int8,
    -- 1=father, 2=mother, 3=guardian
    "user_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_guardian
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table student_guardian
-- ----------------------------
ALTER TABLE
    "public"."student_guardian"
ADD
    CONSTRAINT "student_guardian_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_guardian_id_seq" OWNED BY "public"."student_guardian"."id";

SELECT
    setval(
        '"public"."student_guardian_id_seq"',
        1,
        false
    );