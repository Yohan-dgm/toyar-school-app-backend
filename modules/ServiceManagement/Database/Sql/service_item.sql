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
-- Sequence structure for service_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."service_item_id_seq";

CREATE SEQUENCE "public"."service_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for service_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."service_item";

CREATE TABLE "public"."service_item" (
    "id" int8 NOT NULL DEFAULT nextval('service_item_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "service_item_type_id" int8,
    "service_item_category_id" int8,
    "unit_id" int8,
    "reorder_level" numeric(15, 2),
    "is_expirable" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Records of service_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table service_item
-- ----------------------------
ALTER TABLE
    "public"."service_item"
ADD
    CONSTRAINT "service_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."service_item_id_seq" OWNED BY "public"."service_item"."id";

SELECT
    setval(
        '"public"."service_item_id_seq"',
        1,
        false
    );