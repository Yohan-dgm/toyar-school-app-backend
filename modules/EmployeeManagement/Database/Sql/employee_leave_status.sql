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

 Date: 06/12/2024 15:57:21
*/
-- ----------------------------
-- Sequence structure for employee_leave_status_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."employee_leave_status_id_seq";
CREATE SEQUENCE "public"."employee_leave_status_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for employee_leave_status
-- ----------------------------
DROP TABLE IF EXISTS "public"."employee_leave_status";
CREATE TABLE "public"."employee_leave_status" (
  "id" int8 NOT NULL DEFAULT nextval('employee_leave_status_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL, 
  "created_by" int8,
  "updated_by" timestamp(0)
)
;
-- ----------------------------
-- Records of employee_leave_status
-- ----------------------------
INSERT INTO "public"."employee_leave_status" VALUES (1, 'Approval Pending', NULL, NULL);
INSERT INTO "public"."employee_leave_status" VALUES (2, 'Approved', NULL, NULL);
INSERT INTO "public"."employee_leave_status" VALUES (3, 'Rejected', NULL, NULL); 
INSERT INTO "public"."employee_leave_status" VALUES (4, 'Canceled', NULL, NULL); 

-- ----------------------------
-- Primary Key structure for table employee_leave_status
-- ----------------------------
ALTER TABLE "public"."employee_leave_status" ADD CONSTRAINT "employee_leave_status_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."employee_leave_status_id_seq"
OWNED BY "public"."employee_leave_status"."id";
SELECT setval('"public"."employee_leave_status_id_seq"', 4, true);
