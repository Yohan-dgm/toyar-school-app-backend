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
 
 Date: 08/08/2025 10:30:00
 */

-- ----------------------------
-- Sequence structure for attendance_reasons_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."attendance_reasons_id_seq";

CREATE SEQUENCE "public"."attendance_reasons_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for attendance_reasons
-- ----------------------------
DROP TABLE IF EXISTS "public"."attendance_reasons";

CREATE TABLE "public"."attendance_reasons" (
    "id" int8 NOT NULL DEFAULT nextval('attendance_reasons_id_seq'::regclass),
    "attendance_id" int8 NOT NULL,
    "reason" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table attendance_reasons
-- ----------------------------
ALTER TABLE "public"."attendance_reasons" 
ADD CONSTRAINT "attendance_reasons_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table attendance_reasons
-- ----------------------------
ALTER TABLE "public"."attendance_reasons" 
ADD CONSTRAINT "fk_attendance_reasons_attendance_id" 
FOREIGN KEY ("attendance_id") REFERENCES "public"."student_attendance" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Index for better performance
-- ----------------------------
CREATE INDEX "idx_attendance_reasons_attendance_id" ON "public"."attendance_reasons" USING btree ("attendance_id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."attendance_reasons_id_seq" OWNED BY "public"."attendance_reasons"."id";

SELECT setval('"public"."attendance_reasons_id_seq"', 1, false);