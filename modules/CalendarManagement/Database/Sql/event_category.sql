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
-- Sequence structure for event_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."event_category_id_seq";

CREATE SEQUENCE "public"."event_category_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for event_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."event_category";

CREATE TABLE "public"."event_category" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('event_category_id_seq' :: regclass)
);

-- ----------------------------
-- Records of event_category
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table event_category
-- ----------------------------
ALTER TABLE
    "public"."event_category"
ADD
    CONSTRAINT "event_category_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."event_category_id_seq" OWNED BY "public"."event_category"."id";

SELECT
    setval('"public"."event_category_id_seq"', 1, false);