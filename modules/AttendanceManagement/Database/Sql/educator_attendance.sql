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
-- Sequence structure for educator_attendance_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_attendance_id_seq";
CREATE SEQUENCE "public"."educator_attendance_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for educator_attendance
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator_attendance";
CREATE TABLE "public"."educator_attendance" (
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int8 NOT NULL DEFAULT nextval('educator_attendance_id_seq'::regclass),
  "educator_id" int8,
  "date" date,
  "time" varchar(255) COLLATE "pg_catalog"."default",
  "attendance_type_id" int8
);

-- ----------------------------
-- Records of educator_attendance
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table educator_attendance
-- ----------------------------
ALTER TABLE "public"."educator_attendance" ADD CONSTRAINT "educator_attendance_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_attendance_id_seq"
OWNED BY "public"."educator_attendance"."id";
SELECT setval('"public"."educator_attendance_id_seq"', 1, false);
