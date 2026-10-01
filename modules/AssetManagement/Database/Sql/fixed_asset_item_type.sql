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
-- Sequence structure for fixed_asset_item_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."fixed_asset_item_type_id_seq";

CREATE SEQUENCE "public"."fixed_asset_item_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for fixed_asset_item_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."fixed_asset_item_type";

CREATE TABLE "public"."fixed_asset_item_type" (
    "id" int8 NOT NULL DEFAULT nextval('fixed_asset_item_type_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "sequential_order" int4
);

-- ----------------------------
-- Records of fixed_asset_item_type
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table fixed_asset_item_type
-- ----------------------------
ALTER TABLE
    "public"."fixed_asset_item_type"
ADD
    CONSTRAINT "fixed_asset_item_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."fixed_asset_item_type_id_seq" OWNED BY "public"."fixed_asset_item_type"."id";

SELECT
    setval(
        '"public"."fixed_asset_item_type_id_seq"',
        1,
        false
    );