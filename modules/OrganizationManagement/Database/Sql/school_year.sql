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
-- Sequence structure for school_year_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_year_id_seq";

CREATE SEQUENCE "public"."school_year_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_year
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_year";

CREATE TABLE "public"."school_year" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "start_date" date,
    "end_date" date,
    "school_location_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('school_year_id_seq' :: regclass)
);

-- ----------------------------
-- Records of school_year
-- ----------------------------
INSERT INTO
    "public"."school_year"
VALUES
    (
        'Year 2024-2025',
        '2024-09-01',
        '2025-08-31',
        1,
        Null,
        NULL,
        '2024-12-26',
        NULL,
        1
    );

-- ----------------------------
-- Primary Key structure for table school_year
-- ----------------------------
ALTER TABLE
    "public"."school_year"
ADD
    CONSTRAINT "school_year_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_year_id_seq" OWNED BY "public"."school_year"."id";

SELECT
    setval('"public"."school_year_id_seq"', 1, true);