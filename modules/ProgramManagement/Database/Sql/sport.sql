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
 
 Date: 07/01/2025 12:55:27
 */
-- ----------------------------
-- Sequence structure for sport_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sport_id_seq";

CREATE SEQUENCE "public"."sport_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for sport
-- ----------------------------
DROP TABLE IF EXISTS "public"."sport";

CREATE TABLE "public"."sport" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
   
    "sport_code" varchar(255) COLLATE "pg_catalog"."default",
    "is_active" bool,
    "sport_type" int4,
 
    "created_by" int8,
    "updated_by" int8, 
    "id" int8 NOT NULL DEFAULT nextval('sport_id_seq' :: regclass)
);

-- ----------------------------
-- Records of sport
-- ----------------------------
 
-- ----------------------------
-- Primary Key structure for table sport
-- ----------------------------
ALTER TABLE
    "public"."sport"
ADD
    CONSTRAINT "sport_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."sport_id_seq" OWNED BY "public"."sport"."id";

SELECT
    setval('"public"."sport_id_seq"', 1, false);