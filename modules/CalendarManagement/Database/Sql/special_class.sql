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
 
 Date: 09/12/2024 15:07:41
 */
-- ----------------------------
-- Sequence structure for special_class_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."special_class_id_seq";

CREATE SEQUENCE "public"."special_class_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for special_class
-- ----------------------------
DROP TABLE IF EXISTS "public"."special_class";

CREATE TABLE "public"."special_class" (
    "title" varchar(255) COLLATE "pg_catalog"."default",
    "program_id" int8,
    "subject_id" int8,
    "special_class_date" date,
    "start_time" varchar(255) COLLATE "pg_catalog"."default",
    "end_time" varchar(255) COLLATE "pg_catalog"."default",
    "description" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('special_class_id_seq' :: regclass)
);

-- ----------------------------
-- Records of special_class
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table special_class
-- ----------------------------
ALTER TABLE
    "public"."special_class"
ADD
    CONSTRAINT "special_class_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."special_class_id_seq" OWNED BY "public"."special_class"."id";

SELECT
    setval('"public"."special_class_id_seq"', 1, false);