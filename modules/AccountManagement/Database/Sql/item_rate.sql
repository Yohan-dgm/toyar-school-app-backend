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
-- Sequence structure for item_rate_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."item_rate_id_seq";

CREATE SEQUENCE "public"."item_rate_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for item_rate
-- ----------------------------
DROP TABLE IF EXISTS "public"."item_rate";

CREATE TABLE "public"."item_rate" (
    "id" int8 NOT NULL DEFAULT nextval('item_rate_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "item_type" varchar(255) COLLATE "pg_catalog"."default",
    "school_fee_name" varchar(255) COLLATE "pg_catalog"."default",
    "material_item_id" int8,
    "service_item_id" int8,
    "program_id" int8,
    "subject_id" int8,
    "exam_subject_id" int8,
    "exam_subject_component_id" int8,
    "exam_service_charge_id" int8,
    "rate" numeric(15, 2),
    "version" int8,
    "item_rate_status_id" int8,
    "is_active" bool
);

-- ----------------------------
-- Primary Key structure for table item_rate
-- ----------------------------
ALTER TABLE
    "public"."item_rate"
ADD
    CONSTRAINT "item_rate_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."item_rate_id_seq" OWNED BY "public"."item_rate"."id";

SELECT
    setval('"public"."item_rate_id_seq"', 1, false);