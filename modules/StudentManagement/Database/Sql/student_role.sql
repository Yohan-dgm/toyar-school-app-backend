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
-- Sequence structure for student_role_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_role_id_seq";

CREATE SEQUENCE "public"."student_role_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_role
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_role";

CREATE TABLE "public"."student_role" (
    "id" int8 NOT NULL DEFAULT nextval('student_role_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "student_id" int8,
    "role_type_id" int8,
    "academic_year" varchar(255) COLLATE "pg_catalog"."default",
    "assigned_date" timestamp(0),
    "relieved_date" timestamp(0),
    "remarks" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true
);

-- ----------------------------
-- Primary Key structure for table student_role
-- ----------------------------
ALTER TABLE
    "public"."student_role"
ADD
    CONSTRAINT "student_role_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_role_id_seq" OWNED BY "public"."student_role"."id";

SELECT
    setval(
        '"public"."student_role_id_seq"',
        1,
        false
    );