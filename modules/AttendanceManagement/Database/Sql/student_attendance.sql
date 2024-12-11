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
-- Sequence structure for student_attendance_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_attendance_id_seq";

CREATE SEQUENCE "public"."student_attendance_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_attendance
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_attendance";

CREATE TABLE "public"."student_attendance" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('student_attendance_id_seq' :: regclass),
    "student_id" int8,
    "date" date,
    "time" varchar(255) COLLATE "pg_catalog"."default",
    "attendance_type_id" int8
);

-- ----------------------------
-- Records of student_attendance
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table student_attendance
-- ----------------------------
ALTER TABLE
    "public"."student_attendance"
ADD
    CONSTRAINT "student_attendance_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_attendance_id_seq" OWNED BY "public"."student_attendance"."id";

SELECT
    setval('"public"."student_attendance_id_seq"', 1, false);