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
-- Sequence structure for student_supply_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_supply_id_seq";

CREATE SEQUENCE "public"."student_supply_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_supply
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_supply";

CREATE TABLE "public"."student_supply" (
    "id" int8 NOT NULL DEFAULT nextval('student_supply_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "sequential_order" int4
);

-- ----------------------------
-- Primary Key structure for table student_supply
-- ----------------------------
ALTER TABLE
    "public"."student_supply"
ADD
    CONSTRAINT "student_supply_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_supply_id_seq" OWNED BY "public"."student_supply"."id";

SELECT
    setval(
        '"public"."student_supply_id_seq"',
        1,
        false
    );