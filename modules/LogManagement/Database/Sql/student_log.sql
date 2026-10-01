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
-- Sequence structure for student_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_log_id_seq";

CREATE SEQUENCE "public"."student_log_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_log";

CREATE TABLE "public"."student_log" (
    "id" int8 NOT NULL DEFAULT nextval('student_log_id_seq' :: regclass),
    "description" text,
    "user_name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_log
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table student_log
-- ----------------------------
ALTER TABLE
    "public"."student_log"
ADD
    CONSTRAINT "student_log_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_log_id_seq" OWNED BY "public"."student_log"."id";

SELECT
    setval(
        '"public"."student_log_id_seq"',
        1,
        false
    );