/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 09/12/2024 11:34:59
*/

-- ----------------------------
-- Sequence structure for employee_leave_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."employee_leave_id_seq";
CREATE SEQUENCE "public"."employee_leave_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for employee_leave
-- ----------------------------
DROP TABLE IF EXISTS "public"."employee_leave";
CREATE TABLE "public"."employee_leave" (
  "id" int8 NOT NULL DEFAULT nextval('employee_leave_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "employee_id" int8,
  "leave_date" timestamp(0),
  "leave_duration" int8,
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of employee_leave
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table employee_leave
-- ----------------------------
ALTER TABLE "public"."employee_leave" ADD CONSTRAINT "employee_leave_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."employee_leave_id_seq"
OWNED BY "public"."employee_leave"."id";
SELECT setval('"public"."employee_leave_id_seq"', 1, false);
