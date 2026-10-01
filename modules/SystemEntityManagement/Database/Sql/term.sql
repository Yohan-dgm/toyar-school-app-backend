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
-- Sequence structure for term_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."term_id_seq";

CREATE SEQUENCE "public"."term_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for term
-- ----------------------------
DROP TABLE IF EXISTS "public"."term";

CREATE TABLE "public"."term" (
    "id" int8 NOT NULL DEFAULT nextval('term_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "school_year" varchar(255) COLLATE "pg_catalog"."default",
    "start_date" date,
    "end_date" date,
    -- "is_active" bool,
    "is_current_term" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of term
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table term
-- ----------------------------
ALTER TABLE
    "public"."term"
ADD
    CONSTRAINT "term_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."term_id_seq" OWNED BY "public"."term"."id";

SELECT
    setval(
        '"public"."term_id_seq"',
        1,
        false
    );