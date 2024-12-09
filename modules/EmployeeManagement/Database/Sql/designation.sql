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

 Date: 09/12/2024 11:41:05
*/
-- ----------------------------
-- Sequence structure for designation_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."designation_id_seq";
CREATE SEQUENCE "public"."designation_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for designation
-- ----------------------------
DROP TABLE IF EXISTS "public"."designation";
CREATE TABLE "public"."designation" (
  "id" int8 NOT NULL DEFAULT nextval('designation_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_by" int8,
  "updated_by" timestamp(0)
)
;

 
-- ----------------------------
-- Primary Key structure for table designation
-- ----------------------------
ALTER TABLE "public"."designation" ADD CONSTRAINT "designation_pkey" PRIMARY KEY ("id");


-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."designation_id_seq"
OWNED BY "public"."designation"."id";
SELECT setval('"public"."designation_id_seq"', 1, FALSE);

