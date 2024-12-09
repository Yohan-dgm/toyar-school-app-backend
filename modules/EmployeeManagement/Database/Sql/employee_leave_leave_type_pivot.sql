/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1 
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/12/2024 14:05:35
*/
-- ----------------------------
-- Sequence structure for employee_Leave_leave_type_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."employee_Leave_leave_type_pivot_id_seq";
CREATE SEQUENCE "public"."employee_Leave_leave_type_pivot_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for employee_Leave_leave_type_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."employee_Leave_leave_type_pivot";
CREATE TABLE "public"."employee_Leave_leave_type_pivot" (
  "id" int8 NOT NULL DEFAULT nextval('employee_Leave_leave_type_pivot_id_seq'::regclass),
  "employee_leave_id" int8 NOT NULL,
  "leave_type_id" int8 NOT NULL
)
;

-- ----------------------------
-- Records of employee_Leave_leave_type_pivot
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table employee_Leave_leave_type_pivot
-- ----------------------------
ALTER TABLE "public"."employee_Leave_leave_type_pivot" ADD CONSTRAINT "employee_Leave_leave_type_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."employee_Leave_leave_type_pivot_id_seq"
OWNED BY "public"."employee_Leave_leave_type_pivot"."id";
SELECT setval('"public"."employee_Leave_leave_type_pivot_id_seq"', 1, false);
