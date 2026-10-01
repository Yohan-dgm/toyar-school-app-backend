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
-- Sequence structure for asset_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."asset_item_id_seq";

CREATE SEQUENCE "public"."asset_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for asset_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."asset_item";

CREATE TABLE "public"."asset_item" (
    "id" int8 NOT NULL DEFAULT nextval('asset_item_id_seq' :: regclass),
    "asset_type" varchar(255) COLLATE "pg_catalog"."default",
    "fixed_asset_item_id" int8,
    "current_asset_item_id" int8,
    "goods_received_note_id" int8,
    "received_date" date,
    "received_quantity" numeric(15, 2),
    "current_quantity" numeric(15, 2),
    "unit_price" numeric(15, 2),
    "landed_rate" numeric(15, 2),
    "landed_value" numeric(15, 2),
    "is_unusable" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of asset_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table asset_item
-- ----------------------------
ALTER TABLE
    "public"."asset_item"
ADD
    CONSTRAINT "asset_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."asset_item_id_seq" OWNED BY "public"."asset_item"."id";

SELECT
    setval(
        '"public"."asset_item_id_seq"',
        1,
        false
    );