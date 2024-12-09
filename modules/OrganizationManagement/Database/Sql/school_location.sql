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
-- Sequence structure for school_location_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_location_id_seq";
CREATE SEQUENCE "public"."school_location_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for school_location
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_location";
CREATE TABLE "public"."school_location" (
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" int8,
  "updated_by" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('school_location_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of school_location
-- ----------------------------
INSERT INTO "public"."school_location" VALUES ('Nexis College - Yakkala', 1, NULL, '2024-11-12 16:07:44', NULL, 1);

-- ----------------------------
-- Primary Key structure for table school_location
-- ----------------------------
ALTER TABLE "public"."school_location" ADD CONSTRAINT "school_location_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_location_id_seq"
OWNED BY "public"."school_location"."id";
SELECT setval('"public"."school_location_id_seq"', 1, true);
