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
-- Sequence structure for current_asset_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."current_asset_item_id_seq";

CREATE SEQUENCE "public"."current_asset_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for current_asset_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."current_asset_item";

CREATE TABLE "public"."current_asset_item" (
    "id" int8 NOT NULL DEFAULT nextval('current_asset_item_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "current_asset_item_type_id" int8,
    "current_asset_item_category_id" int8,
    "current_asset_item_sub_category_id" int8,
    "unit_id" int8,
    "reorder_level" numeric(15, 2),
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
-- Records of current_asset_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table current_asset_item
-- ----------------------------
ALTER TABLE
    "public"."current_asset_item"
ADD
    CONSTRAINT "current_asset_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."current_asset_item_id_seq" OWNED BY "public"."current_asset_item"."id";

SELECT
    setval(
        '"public"."current_asset_item_id_seq"',
        1,
        false
    );