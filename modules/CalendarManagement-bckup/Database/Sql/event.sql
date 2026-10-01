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
-- Sequence structure for event_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."event_id_seq";

CREATE SEQUENCE "public"."event_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS "public"."event";

CREATE TABLE "public"."event" (
    "title" varchar(255) COLLATE "pg_catalog"."default",
    "event_category_id" int8,
    "start_date" date,
    "start_time" varchar(255) COLLATE "pg_catalog"."default",
    "end_date" date,
    "end_time" varchar(255) COLLATE "pg_catalog"."default",
    "description" text COLLATE "pg_catalog"."default",
    "visibility_type" varchar(255) COLLATE "pg_catalog"."default",
    "request_visibility_type" varchar(255) COLLATE "pg_catalog"."default",
    "is_approved" bool,
    "approved_by" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('event_id_seq' :: regclass)
);

-- ----------------------------
-- Records of event
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table event
-- ----------------------------
ALTER TABLE
    "public"."event"
ADD
    CONSTRAINT "event_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."event_id_seq" OWNED BY "public"."event"."id";

SELECT
    setval('"public"."event_id_seq"', 1, false);